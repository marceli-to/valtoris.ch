@php
	$links = [
		'leistungen' => 'Leistungen',
		'gesundheitswesen' => 'Gesundheitswesen',
		'team' => 'Team',
	];
	$company = config('valtoris.company');
@endphp

<header
	x-data="{ open: false }"
	@keydown.escape.window="open = false"
	class="sticky top-0 z-40 bg-white"
>
	<div class="container-site flex items-center justify-between py-20 lg:py-32">
		<a href="{{ route('home') }}" class="block w-124 lg:w-207" aria-label="valtoris – zur Startseite">
			<img src="{{ asset('images/logo-valtoris.svg') }}" alt="valtoris – HR · IT · Consulting" width="207" height="66" class="h-auto w-full">
		</a>

		<nav aria-label="Hauptnavigation" class="hidden items-center gap-44 lg:flex">
			@foreach ($links as $anchor => $label)
				<a href="{{ route('home') }}#{{ $anchor }}" class="text-lg font-medium text-verdant hover:underline">{{ $label }}</a>
			@endforeach
			<x-button :href="route('home').'#kontakt'" variant="outline-plum">Kontakt</x-button>
		</nav>

		<button
			type="button"
			class="-mr-10 flex size-44 cursor-pointer flex-col items-end justify-center gap-6 lg:hidden"
			@click="open = true"
			aria-controls="mobile-menu"
			:aria-expanded="open"
		>
			<span class="sr-only">Menü öffnen</span>
			<span class="h-2 w-26 bg-plum"></span>
			<span class="h-2 w-26 bg-plum"></span>
			<span class="h-2 w-18 bg-plum"></span>
		</button>
	</div>

	<div
		id="mobile-menu"
		x-show="open"
		x-cloak
		x-transition.opacity.duration.200ms
		x-trap="open"
		role="dialog"
		aria-modal="true"
		aria-label="Menü"
		class="fixed inset-0 z-50 flex flex-col justify-between overflow-y-auto overscroll-contain bg-white lg:hidden"
	>
		<div class="flex flex-col gap-40">
			{{-- Same box as the header row above, so the logo stays put when the menu opens. --}}
			<div class="container-site flex items-center justify-between py-20">
				<a href="{{ route('home') }}" class="block w-124" aria-label="valtoris – zur Startseite">
					<img src="{{ asset('images/logo-valtoris.svg') }}" alt="" width="207" height="66" class="h-auto w-full">
				</a>
				<button type="button" class="-mr-10 relative size-44 cursor-pointer" @click="open = false">
					<span class="sr-only">Menü schliessen</span>
					<span class="absolute top-1/2 left-1/2 h-2 w-26 -translate-1/2 rotate-45 bg-plum"></span>
					<span class="absolute top-1/2 left-1/2 h-2 w-26 -translate-1/2 -rotate-45 bg-plum"></span>
				</button>
			</div>

			<nav aria-label="Hauptnavigation" class="flex flex-col px-20">
				@foreach ($links as $anchor => $label)
					<a href="{{ route('home') }}#{{ $anchor }}" @click="open = false" class="border-b border-verdant-tint py-18 text-3xl leading-[1.43] font-medium text-verdant">{{ $label }}</a>
				@endforeach
			</nav>

			<div class="px-20 pt-8">
				<x-button :href="route('home').'#kontakt'" variant="outline-plum" @click="open = false">Kontakt</x-button>
			</div>
		</div>

		<address class="px-20 pt-40 pb-40 text-md not-italic">
			{{ $company['name'] }}<br>
			{{ $company['street'] }}, {{ $company['zip'] }} {{ $company['city'] }}<br>
			<a href="mailto:{{ $company['email'] }}" class="hover:underline">{{ $company['email'] }}</a>
		</address>
	</div>
</header>
