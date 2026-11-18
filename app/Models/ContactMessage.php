<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * A message sent with the contact form. `mailed_at` stays empty when the email to
 * valtoris failed, so those can be found and passed on by hand.
 */
#[Fillable(['salutation', 'first_name', 'last_name', 'email', 'phone', 'message', 'mailed_at'])]
class ContactMessage extends Model
{
	protected function casts(): array
	{
		return [
			'mailed_at' => 'datetime',
		];
	}

	public function fullName(): string
	{
		return trim("{$this->first_name} {$this->last_name}");
	}
}
