<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
	use RefreshDatabase;

	private const VERIFY_URL = 'challenges.cloudflare.com/turnstile/v0/siteverify';

	private function input(array $overrides = []): array
	{
		return array_merge([
			'salutation' => 'Frau',
			'first_name' => 'Anna',
			'last_name' => 'Muster',
			'email' => 'anna@example.ch',
			'phone' => '+41 79 123 45 67',
			'message' => 'Wir planen den Wechsel in die HR-Cloud.',
			'cf-turnstile-response' => 'token',
		], $overrides);
	}

	private function turnstile(bool $success): void
	{
		Http::fake([self::VERIFY_URL => Http::response(['success' => $success])]);
	}

	public function test_a_message_is_stored_and_mailed_to_valtoris(): void
	{
		Mail::fake();
		$this->turnstile(true);

		$this->postJson('/kontakt', $this->input())
			->assertCreated()
			->assertJsonPath('data.first_name', 'Anna')
			->assertJsonMissingPath('data.email');

		$message = ContactMessage::sole();
		$this->assertSame('Muster', $message->last_name);
		$this->assertNotNull($message->mailed_at);

		Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
			return $mail->hasTo(config('valtoris.contact_recipient'))
				&& $mail->hasReplyTo('anna@example.ch')
				&& $mail->hasSubject('Kontaktanfrage von Anna Muster');
		});

		Http::assertSent(fn ($request) => $request['response'] === 'token'
			&& $request['secret'] === config('services.turnstile.secret_key'));
	}

	public function test_the_mail_renders_the_message(): void
	{
		$message = ContactMessage::create($this->input());

		(new ContactMessageReceived($message))
			->assertSeeInHtml('Anna Muster')
			->assertSeeInHtml('anna@example.ch')
			->assertSeeInHtml('Wir planen den Wechsel in die HR-Cloud.');
	}

	public function test_only_names_and_email_are_required(): void
	{
		Mail::fake();
		$this->turnstile(true);

		$this->postJson('/kontakt', $this->input(['salutation' => '', 'phone' => '', 'message' => '']))->assertCreated();

		$message = ContactMessage::sole();
		$this->assertNull($message->salutation);
		$this->assertNull($message->phone);
		$this->assertNull($message->message);
	}

	public function test_required_fields_are_checked(): void
	{
		$this->turnstile(true);

		$this->postJson('/kontakt', $this->input(['first_name' => '', 'last_name' => ' ', 'email' => 'nope', 'salutation' => 'Dr.']))
			->assertUnprocessable()
			->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'salutation'])
			->assertJsonPath('errors.email.0', 'Diese E-Mail-Adresse sieht nicht richtig aus.');

		$this->assertDatabaseEmpty('contact_messages');
	}

	public function test_a_failed_turnstile_check_rejects_the_message(): void
	{
		Mail::fake();
		$this->turnstile(false);

		$this->postJson('/kontakt', $this->input())->assertUnprocessable()->assertJsonValidationErrors('cf-turnstile-response');

		$this->assertDatabaseEmpty('contact_messages');
		Mail::assertNothingSent();
	}

	public function test_a_missing_turnstile_token_does_not_call_cloudflare(): void
	{
		Http::fake();

		$this->postJson('/kontakt', $this->input(['cf-turnstile-response' => '']))->assertJsonValidationErrors('cf-turnstile-response');

		Http::assertNothingSent();
	}

	public function test_the_message_is_kept_when_the_mail_fails(): void
	{
		$this->turnstile(true);
		Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

		$this->postJson('/kontakt', $this->input())->assertCreated();

		$this->assertNull(ContactMessage::sole()->mailed_at);
	}

	public function test_without_javascript_the_form_redirects_back_with_a_thank_you(): void
	{
		Mail::fake();
		$this->turnstile(true);

		$this->post('/kontakt', $this->input())->assertRedirect(route('home').'#kontakt');

		$this->get('/')->assertSee('Vielen Dank für Ihre Nachricht.');
	}

	public function test_the_form_is_rate_limited(): void
	{
		Mail::fake();
		$this->turnstile(true);

		for ($i = 0; $i < 5; $i++) {
			$this->postJson('/kontakt', $this->input())->assertCreated();
		}

		$this->postJson('/kontakt', $this->input())->assertTooManyRequests();
	}
}
