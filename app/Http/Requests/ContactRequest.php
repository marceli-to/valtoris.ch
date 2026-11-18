<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * The contact form on the home page. First name, last name and email are required,
 * as marked in the design; the Turnstile token must check out with Cloudflare.
 */
class ContactRequest extends FormRequest
{
	public const SALUTATIONS = ['Frau', 'Herr', 'Divers'];

	public function authorize(): bool
	{
		return true;
	}

	protected function prepareForValidation(): void
	{
		$this->merge(collect(['salutation', 'first_name', 'last_name', 'email', 'phone', 'message'])
			->mapWithKeys(fn (string $field) => [$field => is_string($this->input($field)) ? trim($this->input($field)) : $this->input($field)])
			->all());
	}

	public function rules(): array
	{
		return [
			'salutation' => ['nullable', Rule::in(self::SALUTATIONS)],
			'first_name' => ['required', 'string', 'max:100'],
			'last_name' => ['required', 'string', 'max:100'],
			'email' => ['required', 'email:rfc', 'max:255'],
			'phone' => ['nullable', 'string', 'max:40', 'regex:/^[0-9+()\/.\s-]+$/'],
			'message' => ['nullable', 'string', 'max:5000'],
			'cf-turnstile-response' => ['bail', 'required', new Turnstile($this->ip())],
		];
	}

	public function messages(): array
	{
		return [
			'first_name.required' => 'Bitte geben Sie Ihren Vornamen an.',
			'last_name.required' => 'Bitte geben Sie Ihren Namen an.',
			'email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse an.',
			'email.email' => 'Diese E-Mail-Adresse sieht nicht richtig aus.',
			'phone.regex' => 'Bitte nur Ziffern, Leerzeichen und + ( ) - / verwenden.',
			'salutation.in' => 'Bitte wählen Sie eine der Anreden.',
			'cf-turnstile-response.required' => 'Bitte bestätigen Sie, dass Sie kein Roboter sind.',
			'*.max' => 'Dieser Eintrag ist zu lang (höchstens :max Zeichen).',
		];
	}

	/** The validated input as the attributes of a contact message. */
	public function messageAttributes(): array
	{
		return collect($this->validated())
			->except('cf-turnstile-response')
			->map(fn ($value) => $value === '' ? null : $value)
			->all();
	}
}
