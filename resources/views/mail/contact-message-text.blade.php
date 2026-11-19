{{-- Plain text: nothing is HTML-escaped, so a «&» in the message stays a «&». --}}
@php
	$m = $contactMessage;
	$company = config('valtoris.company');
@endphp
Über das Kontaktformular auf valtoris.ch ist eine neue Anfrage eingegangen.

@if ($m->salutation)
Anrede:       {!! $m->salutation !!}
@endif
Name:         {!! $m->fullName() !!}
E-Mail:       {!! $m->email !!}
@if ($m->phone)
Telefon:      {!! $m->phone !!}
@endif
Eingegangen:  {!! $m->created_at->timezone('Europe/Zurich')->format('d.m.Y, H:i') !!} Uhr

@if ($m->message)
Nachricht:

{!! trim($m->message) !!}
@else
Ohne Nachricht.
@endif

--
{!! $company['name'] !!} · {!! $company['street'] !!} · {!! $company['zip'] !!} {!! $company['city'] !!} · {!! $company['website'] !!}
