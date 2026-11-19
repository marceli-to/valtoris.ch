<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** The contact form message as it arrives at valtoris; replying answers the sender. */
class ContactMessageReceived extends Mailable
{
	public function __construct(public readonly ContactMessage $contactMessage) {}

	public function envelope(): Envelope
	{
		return new Envelope(
			replyTo: [new Address($this->contactMessage->email, $this->contactMessage->fullName())],
			subject: "Kontaktanfrage von {$this->contactMessage->fullName()}",
		);
	}

	public function content(): Content
	{
		return new Content(markdown: 'mail.contact-message', text: 'mail.contact-message-text');
	}
}
