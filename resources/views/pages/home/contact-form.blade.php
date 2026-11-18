{{--
	The contact form. With JavaScript it posts in the background (resources/js/contact-form.js)
	and swaps itself for the thank-you note; without, the page reloads with errors or the note.
	Errors come from both: Blade's @error after a reload, Alpine's errors after a background post.
--}}
@php
	$fields = [
		['name' => 'salutation', 'label' => 'Anrede', 'type' => 'select'],
		['name' => 'phone', 'label' => 'Telefon', 'type' => 'tel', 'autocomplete' => 'tel'],
		['name' => 'first_name', 'label' => 'Vorname*', 'type' => 'text', 'autocomplete' => 'given-name', 'required' => true],
		['name' => 'last_name', 'label' => 'Name*', 'type' => 'text', 'autocomplete' => 'family-name', 'required' => true],
		['name' => 'email', 'label' => 'E-Mail*', 'type' => 'email', 'autocomplete' => 'email', 'required' => true, 'wide' => true],
		['name' => 'message', 'label' => 'Ihre Nachricht', 'type' => 'textarea', 'wide' => true],
	];
@endphp

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
				@foreach ($fields as $field)
					@php
						$name = $field['name'];
						$id = "kontakt-{$name}";
					@endphp
					<div @class(['field', 'sm:col-span-2' => $field['wide'] ?? false])>
						@if ($field['type'] === 'select')
							<select
								id="{{ $id }}"
								name="{{ $name }}"
								class="field-select peer"
								@error($name) aria-invalid="true" @enderror
								:aria-invalid="errors.{{ $name }} ? 'true' : null"
								aria-describedby="{{ $id }}-error"
							>
								<option value=""></option>
								@foreach (App\Http\Requests\ContactRequest::SALUTATIONS as $salutation)
									<option value="{{ $salutation }}" @selected(old($name) === $salutation)>{{ $salutation }}</option>
								@endforeach
							</select>
							<label for="{{ $id }}" class="field-label peer-focus:field-label-floats peer-[:not(:has(option[value='']:checked))]:field-label-floats">{{ $field['label'] }}</label>
						@elseif ($field['type'] === 'textarea')
							<textarea
								id="{{ $id }}"
								name="{{ $name }}"
								rows="3"
								maxlength="5000"
								class="field-input peer h-122 resize-none" placeholder=" "
								@error($name) aria-invalid="true" @enderror
								:aria-invalid="errors.{{ $name }} ? 'true' : null"
								aria-describedby="{{ $id }}-error"
							>{{ old($name) }}</textarea>
							<label for="{{ $id }}" class="field-label peer-focus:field-label-floats peer-[:not(:placeholder-shown)]:field-label-floats">{{ $field['label'] }}</label>
						@else
							<input
								id="{{ $id }}"
								name="{{ $name }}"
								type="{{ $field['type'] }}"
								value="{{ old($name) }}"
								autocomplete="{{ $field['autocomplete'] }}"
								@if ($field['required'] ?? false) required aria-required="true" @endif
								class="field-input peer"
								placeholder=" "
								@error($name) aria-invalid="true" @enderror
								:aria-invalid="errors.{{ $name }} ? 'true' : null"
								aria-describedby="{{ $id }}-error"
							>
							<label for="{{ $id }}" class="field-label peer-focus:field-label-floats peer-[:not(:placeholder-shown)]:field-label-floats">{{ $field['label'] }}</label>
						@endif

						<p id="{{ $id }}-error" class="field-error empty:hidden" x-text="error('{{ $name }}')">@error($name){{ $message }}@enderror</p>
					</div>
				@endforeach
			</div>

			<div class="flex flex-col gap-8">
				<div
					class="cf-turnstile"
					data-sitekey="{{ config('services.turnstile.site_key') }}"
					data-theme="dark"
					data-language="de"
					data-appearance="interaction-only"
				></div>
				<p class="field-error empty:hidden" x-text="error('cf-turnstile-response')">@error('cf-turnstile-response'){{ $message }}@enderror</p>
			</div>

			<div class="flex flex-wrap items-center justify-between gap-20">
				<p class="text-xs text-white/70">* Pflichtfelder</p>
				<button type="submit" class="btn-light" :disabled="sending">
					<span x-show="! sending">Nachricht senden</span>
					<span x-show="sending" x-cloak>Wird gesendet …</span>
				</button>
			</div>

			<p x-show="failed" x-cloak role="alert" class="field-error">
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
