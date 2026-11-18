@php
	$company = config('valtoris.company');
@endphp

<footer class="container-site pb-48 lg:pb-80">
	<div class="flex flex-col gap-28 text-md lg:flex-row lg:gap-96">
		<a href="{{ route('home') }}" class="block w-150 shrink-0 lg:w-207" aria-label="valtoris – zur Startseite">
			<img src="{{ asset('images/logo-valtoris.svg') }}" alt="valtoris – HR · IT · Consulting" width="207" height="66" class="h-auto w-full" loading="lazy">
		</a>

		<div class="flex flex-1 gap-40 lg:gap-64">
			<address class="not-italic">
				{{ $company['name'] }}<br>
				{{ $company['street'] }}<br>
				{{ $company['zip'] }} {{ $company['city'] }}
			</address>
			<p>
				<a href="mailto:{{ $company['email'] }}" class="hover:underline">{{ $company['email'] }}</a><br>
				<a href="{{ route('home') }}" class="hover:underline">{{ $company['website'] }}</a>
			</p>
		</div>

		<ul class="lg:text-right">
			<li><a href="{{ route('impressum') }}" class="hover:underline">Impressum</a></li>
			<li><a href="{{ route('datenschutz') }}" class="hover:underline">Datenschutz</a></li>
			<li>Design by stoz</li>
		</ul>
	</div>
</footer>
