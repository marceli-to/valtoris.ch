@props([
	'title' => 'valtoris – HR, IT & Consulting',
	'description' => 'valtoris verbindet HR und IT, Mensch und Organisation: Beratung zu SAP HCM, HR-Cloud-Systemen, Payroll und Zeitwirtschaft sowie Begleitung im Wandel – mit Schwerpunkt Gesundheitswesen. Aus Maladers, Graubünden.',
])

@php
	// Built from APP_URL, so the canonical address stays the same whichever host the request came in on.
	$canonical = rtrim(config('app.url'), '/').(request()->is('/') ? '/' : '/'.request()->path());
	$company = config('valtoris.company');

	// Built here, not inline: Blade would read '@context' in the template as its @context directive.
	$structuredData = [
		'@context' => 'https://schema.org',
		'@type' => 'ProfessionalService',
		'name' => 'valtoris',
		'legalName' => $company['name'],
		'description' => $description,
		'url' => rtrim(config('app.url'), '/').'/',
		'logo' => asset('images/logo-valtoris.svg'),
		'image' => asset('images/og.png'),
		'email' => $company['email'],
		'address' => [
			'@type' => 'PostalAddress',
			'streetAddress' => $company['street'],
			'postalCode' => $company['zip'],
			'addressLocality' => $company['city'],
			'addressRegion' => 'GR',
			'addressCountry' => $company['country'],
		],
		'areaServed' => 'CH',
		'employee' => collect(config('valtoris.team'))->map(fn (array $person) => [
			'@type' => 'Person',
			'name' => $person['name'],
			'jobTitle' => $person['role'],
			'email' => $person['email'],
			'telephone' => $person['phone'],
		])->all(),
	];
@endphp

<!DOCTYPE html>
<html lang="de-CH">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }}</title>
	<meta name="description" content="{{ $description }}">
	<link rel="canonical" href="{{ $canonical }}">
	@unless (app()->isProduction())
		{{-- Local and staging stay out of search results, also when a crawler ignores robots.txt. --}}
		<meta name="robots" content="noindex, nofollow">
	@endunless
	<meta name="theme-color" content="#ffffff">

	<meta property="og:type" content="website">
	<meta property="og:locale" content="de_CH">
	<meta property="og:site_name" content="valtoris">
	<meta property="og:title" content="{{ $title }}">
	<meta property="og:description" content="{{ $description }}">
	<meta property="og:url" content="{{ $canonical }}">
	<meta property="og:image" content="{{ asset('images/og.png') }}">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="Das Logo von valtoris über den Worten: Wo HR & Technologie zusammenkommen.">
	<meta name="twitter:card" content="summary_large_image">

	<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
	<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon-96x96.png') }}">
	<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
	<link rel="manifest" href="{{ asset('site.webmanifest') }}">

	<script type="application/ld+json">
		{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
	</script>

	{{ $head ?? '' }}

	@fonts

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
	<a href="#inhalt" class="sr-only focus:not-sr-only focus:fixed focus:top-12 focus:left-12 focus:z-50 focus:bg-white focus:px-16 focus:py-8 focus:text-plum">Zum Inhalt springen</a>

	<x-site-header />

	<main id="inhalt">
		{{ $slot }}
	</main>

	<x-site-footer />
</body>
</html>
