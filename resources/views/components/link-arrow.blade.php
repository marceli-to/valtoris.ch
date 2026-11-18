{{-- A text link with an arrow; on hover the arrow moves away and the text is underlined. The colour comes from the caller. --}}
@props(['href'])

<a href="{{ $href }}" {{ $attributes->class('group inline-flex items-center gap-8 self-start text-sm font-medium transition-[gap] duration-200 hover:gap-16') }}>
	{{-- Only the label is underlined: on a flex link the underline would run under the arrow too. The span sets its own colour and offset, since the base rule for links doesn't reach it. --}}
	<span class="decoration-current/50 underline-offset-4 group-hover:underline">{{ $slot }}</span>
	<span class="text-md font-normal" aria-hidden="true">→</span>
	{{ $after ?? '' }}
</a>
