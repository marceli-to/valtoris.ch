<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Tests\TestCase;

class ContactMailTest extends TestCase
{
	private function mail(string $message): ContactMessageReceived
	{
		$contactMessage = new ContactMessage([
			'salutation' => 'Frau',
			'first_name' => 'Andrea',
			'last_name' => 'Muster',
			'email' => 'andrea@example.ch',
			'phone' => '+41 79 123 45 67',
			'message' => $message,
		]);
		$contactMessage->created_at = now();

		return new ContactMessageReceived($contactMessage);
	}

	public function test_the_html_mail_keeps_line_breaks_and_escapes_what_the_sender_typed(): void
	{
		$html = $this->mail("Guten Tag\n\nA | B & *C* <b>D</b>\nAndrea")->render();

		$this->assertStringContainsString('images/logo-mail.png', $html);
		$this->assertStringContainsString('Guten Tag<br><br>A | B &amp; *C* &lt;b&gt;D&lt;/b&gt;<br>Andrea', $html);
		$this->assertStringContainsString('href="mailto:andrea@example.ch"', $html);
		$this->assertStringContainsString('href="tel:+41791234567"', $html);
		$this->assertStringNotContainsString('All rights reserved', $html);
	}

	public function test_the_text_mail_is_plain(): void
	{
		$mail = $this->mail("Guten Tag\n\nA & B\nAndrea");
		$text = view($mail->content()->text, ['contactMessage' => $mail->contactMessage])->render();

		$this->assertStringContainsString("Name:         Andrea Muster\n", $text);
		$this->assertStringContainsString("Guten Tag\n\nA & B\nAndrea", $text);
	}
}
