{{--
	A button in one of the design's styles: a link when it has an href, a <button> otherwise.
	outline: white frame, for dark backgrounds · outline-plum: plum frame, on white · light: white fill, on dark
--}}
@props([
	'href' => null,
	'variant' => 'outline',
	'type' => 'button',
])

@php
	$classes = Arr::toCssClasses([
		'inline-flex h-48 cursor-pointer items-center justify-center gap-8 border px-20 text-lg leading-normal font-medium transition-colors duration-200 disabled:cursor-wait disabled:opacity-70',
		'border-white text-white hover:bg-white hover:text-plum focus-visible:outline-white' => $variant === 'outline',
		'border-plum text-plum hover:bg-plum hover:text-white' => $variant === 'outline-plum',
		'border-white bg-white text-plum hover:bg-transparent hover:text-white focus-visible:outline-white' => $variant === 'light',
	]);
@endphp

@if ($href)
	<a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
	<button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
