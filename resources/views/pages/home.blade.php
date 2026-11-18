<x-layouts.app>
	<x-slot:head>
		<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
	</x-slot:head>

	@include('pages.home.hero')
	@include('pages.home.topics')
	@include('pages.home.services')
	@include('pages.home.health')
	@include('pages.home.team')
	@include('pages.home.contact')
</x-layouts.app>
