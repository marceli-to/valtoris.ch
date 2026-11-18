<?php

namespace App\Http\Resources;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * The answer to a contact form sent in the background: just enough to thank the
 * sender by name. Nothing else of the stored message goes back out.
 *
 * @mixin ContactMessage
 */
class ContactMessageResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'first_name' => $this->first_name,
			'received_at' => $this->created_at->toIso8601String(),
		];
	}
}
