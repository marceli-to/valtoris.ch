<x-mail::message>
# Neue Kontaktanfrage

Über das Formular auf valtoris.ch ist eine Nachricht eingegangen. Mit «Antworten» geht die Antwort direkt an {{ $contactMessage->fullName() }}.

<x-mail::table>
| | |
|:--|:--|
@if ($contactMessage->salutation)
| Anrede | {{ $contactMessage->salutation }} |
@endif
| Name | {{ $contactMessage->fullName() }} |
| E-Mail | {{ $contactMessage->email }} |
@if ($contactMessage->phone)
| Telefon | {{ $contactMessage->phone }} |
@endif
| Eingegangen | {{ $contactMessage->created_at->timezone('Europe/Zurich')->format('d.m.Y, H:i') }} Uhr |
</x-mail::table>

@if ($contactMessage->message)
**Nachricht**

{{ $contactMessage->message }}
@else
*Ohne Nachricht.*
@endif
</x-mail::message>
