<?php

namespace App\Actions\Contact;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

/**
 * Stores a message from the contact form and emails it to valtoris. The message is
 * saved first, so a failing mail server loses nothing: the error is reported and
 * the message stays in the database with `mailed_at` empty.
 */
class SubmitContactMessage
{
	/** @param  array{salutation?: ?string, first_name: string, last_name: string, email: string, phone?: ?string, message?: ?string}  $attributes */
	public function execute(array $attributes): ContactMessage
	{
		$message = ContactMessage::create($attributes);

		try {
			Mail::to(config('valtoris.contact_recipient'))->send(new ContactMessageReceived($message));
			$message->update(['mailed_at' => now()]);
		} catch (\Throwable $e) {
			report($e);
		}

		return $message;
	}
}
