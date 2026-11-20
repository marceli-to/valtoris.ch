<x-layouts.app>
	<x-slot:head>
		{{-- The hero video's poster is the largest paint on load; the browser would only find it late. --}}
		<link rel="preload" as="image" href="{{ asset('images/hero-poster-1280.jpg') }}" fetchpriority="high">
	</x-slot:head>

	@include('pages.home.hero')
	@include('pages.home.topics')
	@include('pages.home.services')
	@include('pages.home.health')
	@include('pages.home.team')
	@include('pages.home.contact')
</x-layouts.app>
