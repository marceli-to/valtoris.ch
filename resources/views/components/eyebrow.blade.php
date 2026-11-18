{{--
	The small uppercase label above a heading, led by a square. The text colour comes from the caller; the square takes it too unless `square` names a background class.
	The square sits on the text's baseline, raised by half the difference between the capitals (0.7em = 9.8px) and itself (8px), so it centres on the letters. Hanging it on the baseline
	instead of flex-centring it keeps square and letters on the same reference line, so they round to the same screen pixels wherever the eyebrow lands.
--}}
@props(['square' => 'bg-current'])

<p {{ $attributes->class('text-xs leading-20 font-medium tracking-[0.1em] uppercase') }}>
	<span class="mr-12 inline-block size-8 align-[0.9px] {{ $square }}" aria-hidden="true"></span>{{ $slot }}
</p>
