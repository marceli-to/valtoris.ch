{{-- A text link with an arrow; on hover the arrow moves away and the text is underlined. The colour comes from the caller. --}}
@props(['href'])

<a href="{{ $href }}" {{ $attributes->class('inline-flex items-center gap-8 self-start text-sm font-medium transition-[gap] duration-200 hover:gap-16 hover:underline') }}>
	{{ $slot }}
	{{-- inline-block keeps the underline off the arrow --}}
	<span class="inline-block text-md font-normal" aria-hidden="true">→</span>
	{{ $after ?? '' }}
</a>
