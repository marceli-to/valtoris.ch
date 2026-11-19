@php
	$company = config('valtoris.company');
@endphp
<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ $company['name'] }}
</x-mail::header>
</x-slot:header>

{{ $slot }}

@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
{{ $company['name'] }} · {{ $company['street'] }} · {{ $company['zip'] }} {{ $company['city'] }} · {{ $company['website'] }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
