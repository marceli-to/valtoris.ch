{{-- The small uppercase label above a heading, led by a square. The text colour comes from the caller; the square takes it too unless `square` names a background class. --}}
@props(['square' => 'bg-current'])

<p {{ $attributes->class('flex items-center gap-12 text-xs font-medium tracking-[0.1em] uppercase') }}>
	<span class="size-8 shrink-0 {{ $square }}" aria-hidden="true"></span>
	{{ $slot }}
</p>
