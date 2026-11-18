{{--
	A photo from resources/images/images.json as AVIF, WebP and JPEG, at every width
	scripts/images.mjs rendered. Pass `sizes` for how wide it shows on the page.
--}}
@props([
	'name',
	'alt' => '',
	'sizes' => '100vw',
	'loading' => 'lazy',
	'imgClass' => '',
])

@php
	$image = json_decode(file_get_contents(resource_path('images/images.json')), true)[$name];
	$widths = array_filter($image['widths'], fn (int $width) => $width <= $image['width']);
	$srcset = fn (string $extension) => collect($widths)
		->map(fn (int $width) => asset("images/{$name}-{$width}.{$extension}")." {$width}w")
		->implode(', ');
@endphp

<picture {{ $attributes }}>
	<source type="image/avif" srcset="{{ $srcset('avif') }}" sizes="{{ $sizes }}">
	<source type="image/webp" srcset="{{ $srcset('webp') }}" sizes="{{ $sizes }}">
	<img
		src="{{ asset("images/{$name}-".max($widths).'.jpg') }}"
		srcset="{{ $srcset('jpg') }}"
		sizes="{{ $sizes }}"
		width="{{ $image['width'] }}"
		height="{{ $image['height'] }}"
		alt="{{ $alt }}"
		loading="{{ $loading }}"
		decoding="async"
		@if ($loading === 'eager') fetchpriority="high" @endif
		class="{{ $imgClass }}"
	>
</picture>
