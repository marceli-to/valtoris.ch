@php
	$company = config('valtoris.company');
	$team = config('valtoris.team');
@endphp

<x-legal-page eyebrow="Impressum" title="Impressum" description="Impressum von valtoris gmbh, Schlossweg 2, 7026 Maladers: Kontakt, Handelsregister, Haftungsausschluss und Urheberrechte.">
	<x-legal-section title="Verantwortlich für den Inhalt">
		<p>
			{{ $company['name'] }}<br>
			{{ $company['street'] }}<br>
			{{ $company['zip'] }} {{ $company['city'] }}<br>
			Schweiz
		</p>
		<p>Vertreten durch {{ collect($team)->pluck('name')->join(', ', ' und ') }}.</p>
	</x-legal-section>

	<x-legal-section title="Kontakt">
		<p>E-Mail: <a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a></p>
		<p>
			@foreach ($team as $person)
				{{ $person['name'] }}: <a href="tel:{{ str_replace(' ', '', $person['phone']) }}">{{ $person['phone'] }}</a>@if (! $loop->last)<br>@endif
			@endforeach
		</p>
	</x-legal-section>

	<x-legal-section title="Handelsregister">
		<p>
			Eingetragen im Handelsregister des Kantons Graubünden.<br>
			Unternehmens-Identifikationsnummer (UID): {{ config('valtoris.company.uid') ?? 'CHE-XXX.XXX.XXX' }}
		</p>
	</x-legal-section>

	<x-legal-section title="Haftungsausschluss">
		<p>
			Wir prüfen die Inhalte dieser Website sorgfältig. Für die Richtigkeit, Genauigkeit, Aktualität, Zuverlässigkeit und Vollständigkeit der Informationen übernehmen wir dennoch keine Gewähr. Haftungsansprüche wegen Schäden materieller oder immaterieller Art, die aus dem Zugriff auf die veröffentlichten Informationen, durch deren Nutzung oder Nichtnutzung, durch Missbrauch der Verbindung oder durch technische Störungen entstanden sind, werden ausgeschlossen.
		</p>
		<p>
			Verweise und Links auf Websites Dritter liegen ausserhalb unseres Verantwortungsbereichs. Für deren Inhalte sind ausschliesslich die jeweiligen Betreiberinnen und Betreiber verantwortlich; der Zugriff und die Nutzung solcher Websites erfolgen auf eigene Gefahr.
		</p>
	</x-legal-section>

	<x-legal-section title="Urheberrechte">
		<p>
			Die Urheber- und alle anderen Rechte an Inhalten, Bildern, Fotos, Grafiken oder anderen Dateien auf dieser Website gehören ausschliesslich der {{ $company['name'] }} oder den speziell genannten Rechteinhabern. Für die Reproduktion jeglicher Elemente ist die schriftliche Zustimmung der Urheberrechtsträger im Voraus einzuholen.
		</p>
		<p>Gestaltung: stoz</p>
	</x-legal-section>
</x-legal-page>
