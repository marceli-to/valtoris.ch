{{-- The two partners. Hovering (or tapping) a photo shows the person's quote over it. --}}
<section id="team" class="container-site flex scroll-mt-88 flex-col gap-40 pb-80 md:pb-160 lg:scroll-mt-128 lg:flex-row lg:gap-80" aria-labelledby="team-title">
	<div class="flex shrink-0 flex-col gap-20 md:gap-28 lg:w-400">
		<x-eyebrow class="reveal text-plum" data-reveal>Team</x-eyebrow>
		<h2 id="team-title" class="heading-section reveal" data-reveal>Menschen, die mitdenken.</h2>
		<p class="text-body reveal" data-reveal>
			Zwei Partner, ein Anspruch: Kompetenz statt Bauchgefühl und Zusammenarbeit auf Augenhöhe – unkompliziert, ehrlich und pragmatisch.
		</p>
	</div>

	<div class="grid flex-1 gap-48 sm:grid-cols-2 sm:gap-24">
		@foreach (config('valtoris.team') as $person)
			@php
				$plum = $person['colour'] === 'plum';
				$profile = file_exists(public_path($person['profile'])) ? $person['profile'] : null;
			@endphp

			<article data-reveal class="reveal flex flex-col gap-20 md:gap-24">
				<figure x-data="{ quote: false }" @click="quote = ! quote" @mouseleave="quote = false" class="group relative isolate h-400 cursor-default overflow-hidden md:h-420">
					<x-picture
						:name="$person['photo']"
						:alt="'Porträt von '.$person['name']"
						sizes="(min-width: 1440px) 388px, (min-width: 640px) 50vw, 100vw"
						class="absolute inset-0 -z-10"
						img-class="size-full object-cover"
					/>
					<div @class(['absolute inset-0 -z-10 bg-linear-to-b from-55%', 'from-plum/0 to-plum/90' => $plum, 'from-verdant/0 to-verdant/90' => ! $plum])></div>

					<figcaption :class="quote && 'opacity-0'" class="flex h-full flex-col justify-end gap-8 px-24 pb-24 text-white transition-opacity duration-300 group-hover:opacity-0 md:px-28">
						<x-eyebrow :square="$plum ? 'bg-plum-tint' : 'bg-verdant-tint'">{{ $person['role'] }}</x-eyebrow>
						<span class="text-2xl font-medium tracking-[-0.01em]">{{ $person['name'] }}</span>
					</figcaption>

					<blockquote
						:class="quote && 'opacity-100'"
						class="absolute inset-0 isolate flex flex-col justify-end px-24 pt-20 pb-24 text-xl leading-[1.35] font-light tracking-[-0.01em] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100 md:px-28"
					>
						{{-- The gradient lets the portrait show through; the quote itself stays fully white. --}}
						<div @class(['absolute inset-0 -z-10 opacity-85', 'bg-quote-plum' => $plum, 'bg-quote-verdant' => ! $plum])></div>
						<p>«{!! nl2br(e($person['quote']), false) !!}»</p>
					</blockquote>
				</figure>

				<p class="flex flex-col gap-4 text-md">
					<a href="tel:{{ str_replace(' ', '', $person['phone']) }}" class="self-start hover:underline">{{ $person['phone'] }}</a>
					<a href="mailto:{{ $person['email'] }}" class="self-start hover:underline">{{ $person['email'] }}</a>
				</p>

				@if ($profile)
					<div class="h-px bg-verdant-tint"></div>
					<x-link-arrow :href="asset($profile)" class="text-plum" target="_blank" rel="noopener">
						Beraterprofil
						<x-slot:after><span class="sr-only">von {{ $person['name'] }} (PDF)</span></x-slot:after>
					</x-link-arrow>
				@endif
			</article>
		@endforeach
	</div>
</section>
