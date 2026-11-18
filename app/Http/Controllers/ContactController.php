<?php

namespace App\Http\Controllers;

use App\Actions\Contact\SubmitContactMessage;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactMessageResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/** The contact form: JSON for the background post, a redirect back to the form without JavaScript. */
class ContactController extends Controller
{
	public function store(ContactRequest $request, SubmitContactMessage $submit): JsonResponse|RedirectResponse
	{
		$message = $submit->execute($request->messageAttributes());

		if ($request->expectsJson()) {
			return ContactMessageResource::make($message)->response()->setStatusCode(201);
		}

		return redirect()->to(route('home').'#kontakt')->with('contact_sent', true);
	}
}
