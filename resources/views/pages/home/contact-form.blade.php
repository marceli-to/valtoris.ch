{{--
	The contact form. With JavaScript it posts in the background (resources/js/contact-form.js)
	and swaps itself for the thank-you note; without, the page reloads with errors or the note.
	The fields are <x-contact-field>.
--}}
<div x-data="contactForm" class="lg:pt-8">
	@if (session('contact_sent'))
		<div role="status" class="flex flex-col gap-16">
			<p class="text-2xl font-medium">Vielen Dank für Ihre Nachricht.</p>
			<p class="text-body text-white/85">Wir melden uns so bald wie möglich bei Ihnen.</p>
		</div>
	@else
		<form
			method="POST"
			action="{{ route('contact.store') }}"
			x-show="! sent"
			@submit.prevent="submit"
			novalidate
			class="flex flex-col gap-36"
		>
			@csrf

			<div class="grid gap-x-32 gap-y-36 sm:grid-cols-2">
				<x-contact-field name="salutation" label="Anrede" type="select" :options="App\Http\Requests\ContactRequest::SALUTATIONS" />
				<x-contact-field name="phone" label="Telefon" type="tel" autocomplete="tel" />
				<x-contact-field name="first_name" label="Vorname*" autocomplete="given-name" required />
				<x-contact-field name="last_name" label="Name*" autocomplete="family-name" required />
				<x-contact-field name="email" label="E-Mail*" type="email" autocomplete="email" required class="sm:col-span-2" />
				<x-contact-field name="message" label="Ihre Nachricht" type="textarea" class="sm:col-span-2" />
			</div>

			<div class="flex flex-col gap-8">
				<div
					class="cf-turnstile"
					data-sitekey="{{ config('services.turnstile.site_key') }}"
					data-theme="dark"
					data-language="de"
					data-appearance="interaction-only"
				></div>
				<p class="text-xs text-amber empty:hidden" x-text="error('cf-turnstile-response')">@error('cf-turnstile-response'){{ $message }}@enderror</p>
			</div>

			<div class="flex flex-wrap items-center justify-between gap-20">
				<p class="text-xs text-white/70">* Pflichtfelder</p>
				<x-button type="submit" variant="light" ::disabled="sending">
					<span x-show="! sending">Nachricht senden</span>
					<span x-show="sending" x-cloak>Wird gesendet …</span>
				</x-button>
			</div>

			<p x-show="failed" x-cloak role="alert" class="text-xs text-amber">
				Das hat leider nicht geklappt. Bitte versuchen Sie es noch einmal oder schreiben Sie uns an
				<a href="mailto:{{ config('valtoris.company.email') }}" class="underline">{{ config('valtoris.company.email') }}</a>.
			</p>
		</form>

		<div x-show="sent" x-cloak x-ref="thanks" tabindex="-1" role="status" class="flex flex-col gap-16 focus:outline-none">
			<p class="text-2xl font-medium">Vielen Dank<span x-show="firstName" x-text="', ' + firstName"></span>.</p>
			<p class="text-body text-white/85">Ihre Nachricht ist bei uns angekommen. Wir melden uns so bald wie möglich bei Ihnen.</p>
		</div>
	@endif
</div>
