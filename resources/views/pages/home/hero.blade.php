{{-- The hero: video under three gradient layers (multiply, hard light) as in the design. Without the video, its first frame stands in. --}}
@php
	$video = file_exists(public_path('videos/valtoris.mp4'));
@endphp

<section class="container-site" aria-labelledby="hero-title">
	<div class="box flex min-h-600 flex-col justify-end pt-32 md:min-h-800 md:pt-64">
		<div class="absolute inset-0 -z-20" aria-hidden="true">
			<div class="bg-hero absolute inset-0"></div>
			@if ($video)
				<video
					class="absolute inset-0 size-full object-cover mix-blend-hard-light motion-reduce:hidden"
					autoplay muted loop playsinline preload="metadata"
					poster="{{ asset('images/hero-poster-1280.jpg') }}"
				>
					@if (file_exists(public_path('videos/valtoris.webm')))
						<source src="{{ asset('videos/valtoris.webm') }}" type="video/webm">
					@endif
					<source src="{{ asset('videos/valtoris.mp4') }}" type="video/mp4">
				</video>
			@endif
			<x-picture
				name="hero-poster"
				sizes="(min-width: 1440px) 1280px, 100vw"
				:loading="$video ? 'lazy' : 'eager'"
				:class="Arr::toCssClasses(['absolute inset-0 mix-blend-hard-light', 'hidden motion-reduce:block' => $video])"
				img-class="size-full object-cover"
			/>
			<div class="bg-hero absolute inset-0 opacity-27 mix-blend-multiply"></div>
			<div class="bg-hero absolute inset-0 mix-blend-hard-light"></div>
		</div>

		<div class="flex flex-col gap-28 md:gap-48">
			<h1 id="hero-title" class="heading-hero">
				Wo <span class="text-plum-tint">HR&nbsp;&amp; Technologie</span><br class="max-sm:hidden">
				zusammen&shy;kommen.
			</h1>
			<div class="flex flex-col items-start gap-32">
				<p class="text-body max-w-540 text-white/85">
					Wir verbinden HR und IT, Mensch und Organisation. Ob SAP HCM, Cloud-Systeme oder Payroll: Wir schaffen Klarheit, vereinfachen Prozesse und begleiten Veränderung – pragmatisch, partnerschaftlich und technologiegestützt.
				</p>
				<x-button href="#leistungen">Leistungen entdecken</x-button>
			</div>
		</div>

		<div class="pattern-band" aria-hidden="true"></div>
	</div>
</section>
