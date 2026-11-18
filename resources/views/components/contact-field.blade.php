{{--
	One field of the contact form, as in the design: a label sitting on a line. The label rests
	where the text goes and moves up once the field has focus or a value; it comes after the
	control so it can follow the control's state (peer). Errors come from Blade after a reload
	and from Alpine (contact-form.js) after a background post.
--}}
@props([
	'name',
	'label',
	'type' => 'text',
	'autocomplete' => null,
	'required' => false,
	'options' => [],
])

@php
	$id = "kontakt-{$name}";
	// The chevron url is relative to resources/css/app.css, where Tailwind writes the class, so Vite bundles it.
	$control = 'peer w-full appearance-none rounded-none border-0 border-b border-white/50 bg-transparent px-0 pt-0 pb-12 text-lg text-white transition-colors placeholder:text-transparent focus:border-white focus:outline-none aria-invalid:border-amber';
	$labelClasses = 'pointer-events-none absolute top-0 left-0 origin-top-left text-sm leading-[22px] text-white/85 transition-transform duration-200 peer-focus:-translate-y-24 peer-focus:scale-87';
	$floatsWhenFilled = $type === 'select'
		? "peer-[:not(:has(option[value='']:checked))]:-translate-y-24 peer-[:not(:has(option[value='']:checked))]:scale-87"
		: 'peer-[:not(:placeholder-shown)]:-translate-y-24 peer-[:not(:placeholder-shown)]:scale-87';
@endphp

<div {{ $attributes->class('relative flex flex-col gap-8') }}>
	@if ($type === 'select')
		<select
			id="{{ $id }}"
			name="{{ $name }}"
			class="{{ $control }} cursor-pointer bg-[url(../images/chevron-down.svg)] bg-position-[right_4px_top_10px] bg-no-repeat pr-24 *:text-text"
			@error($name) aria-invalid="true" @enderror
			:aria-invalid="errors.{{ $name }} ? 'true' : null"
			aria-describedby="{{ $id }}-error"
		>
			<option value=""></option>
			@foreach ($options as $option)
				<option value="{{ $option }}" @selected(old($name) === $option)>{{ $option }}</option>
			@endforeach
		</select>
	@elseif ($type === 'textarea')
		<textarea
			id="{{ $id }}"
			name="{{ $name }}"
			rows="3"
			maxlength="5000"
			placeholder=" "
			class="{{ $control }} h-120 resize-none"
			@error($name) aria-invalid="true" @enderror
			:aria-invalid="errors.{{ $name }} ? 'true' : null"
			aria-describedby="{{ $id }}-error"
		>{{ old($name) }}</textarea>
	@else
		<input
			id="{{ $id }}"
			name="{{ $name }}"
			type="{{ $type }}"
			value="{{ old($name) }}"
			placeholder=" "
			@if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
			@if ($required) required aria-required="true" @endif
			class="{{ $control }}"
			@error($name) aria-invalid="true" @enderror
			:aria-invalid="errors.{{ $name }} ? 'true' : null"
			aria-describedby="{{ $id }}-error"
		>
	@endif

	<label for="{{ $id }}" class="{{ $labelClasses }} {{ $floatsWhenFilled }}">{{ $label }}</label>

	<p id="{{ $id }}-error" class="text-xs text-amber empty:hidden" x-text="error('{{ $name }}')">@error($name){{ $message }}@enderror</p>
</div>
