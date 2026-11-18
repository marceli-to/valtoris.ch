{{-- The topic band: the words alternate green and plum, each followed by a square in the other colour. Two copies make the loop seamless. It stops while the pointer is over it (WCAG 2.2.2). --}}
@php
	$topics = config('valtoris.topics');
@endphp

<div class="overflow-hidden py-40 md:py-72">
	<div class="flex w-max animate-marquee hover:[animation-play-state:paused] motion-reduce:animate-none">
		@foreach ([false, true] as $copy)
			<ul class="flex shrink-0 items-center" @if ($copy) aria-hidden="true" @else aria-label="Unsere Themen" @endif>
				@foreach ($topics as $topic)
					<li class="flex items-center text-7xl leading-[1.45] font-light whitespace-nowrap">
						<span @class(['text-verdant' => $loop->odd, 'text-plum' => $loop->even])>{{ $topic }}</span>
						<span @class(['mx-32 size-8 shrink-0', 'bg-plum' => $loop->odd, 'bg-verdant' => $loop->even]) aria-hidden="true"></span>
					</li>
				@endforeach
			</ul>
		@endforeach
	</div>
</div>
