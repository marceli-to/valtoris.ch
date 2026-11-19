{{-- Laravel's mail frame with the valtoris logo at the top of the card (PNG: email apps don't show SVG) and the company line, in German, below it. --}}
@php
	$company = config('valtoris.company');
@endphp
<x-mail::layout>
<p class="logo-row"><a href="{{ config('app.url') }}"><img src="{{ asset('images/logo-mail.png') }}" class="logo" width="160" height="51" alt="valtoris – HR · IT · Consulting"></a></p>

{!! $slot !!}

@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
{{ $company['name'] }} · {{ $company['street'] }} · {{ $company['zip'] }} {{ $company['city'] }}<br>
[{{ $company['website'] }}]({{ config('app.url') }})
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
