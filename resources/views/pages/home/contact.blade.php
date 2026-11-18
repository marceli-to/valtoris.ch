<section id="kontakt" class="container-site scroll-mt-90 pb-64 md:pb-80 lg:scroll-mt-130" aria-labelledby="kontakt-title">
	<div class="box bg-contact grid gap-40 pt-32 text-white md:pt-72 lg:grid-cols-[440px_1fr] lg:gap-96">
		<div class="flex flex-col gap-24">
			<p class="eyebrow [--eyebrow-square:var(--color-plum-tint)]">Kontakt</p>
			<h2 id="kontakt-title" class="text-5xl font-medium tracking-[-0.015em] md:text-8xl">Jetzt Kontakt aufnehmen.</h2>
			<p class="text-body text-white/85">
				Wir freuen uns über eine unverbindliche Kontaktaufnahme – direkt bei der jeweiligen Ansprechperson oder über das Formular.
			</p>
			<ul class="mt-16 border-y border-white/30 text-md">
				@foreach (config('valtoris.team') as $person)
					<li @class(['flex items-start justify-between gap-16 py-16', 'border-t border-white/30' => ! $loop->first])>
						<span class="font-medium">{{ $person['name'] }}</span>
						<a href="tel:{{ str_replace(' ', '', $person['phone']) }}" class="text-white/85 hover:text-white hover:underline">{{ $person['phone'] }}</a>
					</li>
				@endforeach
			</ul>
		</div>

		@include('pages.home.contact-form')

		<div class="pattern-band" aria-hidden="true"></div>
	</div>
</section>
