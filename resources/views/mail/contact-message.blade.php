{{--
	The contact form message as it arrives at valtoris. The details and the message are HTML blocks, not
	Markdown, so whatever the sender typed (a | or a *) shows as typed; line breaks in the message are kept.
--}}
@php
	$m = $contactMessage;
	$rows = array_filter([
		'Anrede' => e($m->salutation),
		'Name' => e($m->fullName()),
		'E-Mail' => '<a href="mailto:'.e($m->email).'">'.e($m->email).'</a>',
		'Telefon' => $m->phone ? '<a href="tel:'.e(preg_replace('/[^\d+]/', '', $m->phone)).'">'.e($m->phone).'</a>' : null,
		'Eingegangen' => e($m->created_at->timezone('Europe/Zurich')->format('d.m.Y, H:i')).' Uhr',
	]);
@endphp
<x-mail::message>
<p class="intro">Über das Kontaktformular auf valtoris.ch ist eine neue Anfrage eingegangen.</p>

<table class="details" width="100%" cellpadding="0" cellspacing="0" role="presentation">
@foreach ($rows as $label => $value)
<tr><td class="details-label">{{ $label }}</td><td class="details-value">{!! $value !!}</td></tr>
@endforeach
</table>

@if ($m->message)
<table class="message" width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr><td class="message-cell">{!! str_replace(["\r\n", "\r", "\n"], '<br>', e(trim($m->message))) !!}</td></tr></table>
@else
<p class="lead">Ohne Nachricht.</p>
@endif
</x-mail::message>
