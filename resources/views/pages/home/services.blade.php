{{-- Seven services and a call to contact, in a grid whose 1px gaps draw the lines between the cells. --}}
<section id="leistungen" class="container-site scroll-mt-88 pt-24 pb-80 md:pt-32 md:pb-160 lg:scroll-mt-128" aria-labelledby="leistungen-title">
	<div class="flex flex-col gap-20 lg:flex-row lg:items-end lg:justify-between">
		<div class="flex flex-col gap-28">
			<x-eyebrow class="text-plum">Leistungen</x-eyebrow>
			<h2 id="leistungen-title" class="heading-page">Was wir bewegen.</h2>
		</div>
		<p class="text-body max-w-612 lg:pb-4">
			Sieben Kompetenzfelder, ein Anspruch:<br class="max-lg:hidden">
			HR und IT so verbinden, dass Menschen und<br class="max-lg:hidden">
			Organisationen gemeinsam wachsen.
		</p>
	</div>

	<ul class="mt-40 grid gap-px bg-verdant-tint py-px md:mt-80 md:grid-cols-2 xl:grid-cols-4">
		@foreach (config('valtoris.services') as $service)
			<li class="flex flex-col gap-24 bg-white pt-28 pb-32 md:gap-40 md:px-28 md:pt-32 md:pb-40">
				<div class="flex items-center justify-between">
					<span @class(['flex size-48 items-center justify-center', 'bg-plum' => $service['colour'] === 'plum', 'bg-verdant' => $service['colour'] === 'verdant'])>
						<img src="{{ asset("images/icons/{$service['icon']}.svg") }}" alt="" loading="lazy">
					</span>
					<span @class(['text-xs font-medium tracking-[0.1em]', 'text-plum' => $service['colour'] === 'plum', 'text-verdant' => $service['colour'] === 'verdant'])>
						{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
					</span>
				</div>
				<div class="flex flex-col gap-16">
					<h3 @class(['heading-card', 'text-plum' => $service['colour'] === 'plum', 'text-verdant' => $service['colour'] === 'verdant'])>
						{!! nl2br(e($service['title']), false) !!}
					</h3>
					<p class="text-body">{{ $service['text'] }}</p>
				</div>
			</li>
		@endforeach

		<li class="bg-cta flex min-h-280 flex-col justify-between gap-40 px-24 py-32 text-white md:px-28 md:pt-44 md:pb-40">
			<x-eyebrow square="bg-verdant-tint">Ihr Thema?</x-eyebrow>
			<div class="flex flex-col gap-20">
				<p class="text-2xl font-medium tracking-[-0.005em]">Noch nicht das Richtige dabei? Interesse geweckt?</p>
				<x-link-arrow href="#kontakt">Jetzt Kontakt aufnehmen</x-link-arrow>
			</div>
		</li>
	</ul>
</section>
