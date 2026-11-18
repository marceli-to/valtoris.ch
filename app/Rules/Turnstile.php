<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Checks a Cloudflare Turnstile token with Cloudflare's siteverify endpoint.
 * If Cloudflare can't be reached the token counts as invalid: better a retry
 * than a form that lets everything through.
 */
class Turnstile implements ValidationRule
{
	private const VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

	public function __construct(private readonly ?string $ip = null) {}

	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if (! is_string($value) || $value === '') {
			$fail('Bitte bestätigen Sie, dass Sie kein Roboter sind.');

			return;
		}

		try {
			$response = Http::asForm()
				->timeout(5)
				->post(self::VERIFY_URL, array_filter([
					'secret' => config('services.turnstile.secret_key'),
					'response' => $value,
					'remoteip' => $this->ip,
				]));
		} catch (\Throwable $e) {
			Log::warning('Turnstile verification failed', ['error' => $e->getMessage()]);
			$fail('Die Sicherheitsprüfung ist fehlgeschlagen. Bitte versuchen Sie es noch einmal.');

			return;
		}

		if (! $response->json('success')) {
			$fail('Die Sicherheitsprüfung ist fehlgeschlagen. Bitte versuchen Sie es noch einmal.');
		}
	}
}
