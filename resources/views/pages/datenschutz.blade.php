@php
	$company = config('valtoris.company');
	$hosting = config('valtoris.hosting');
@endphp

<x-legal-page eyebrow="Datenschutz" title="Datenschutzerklärung" description="Wie valtoris gmbh Personendaten auf valtoris.ch bearbeitet: Server-Logfiles, Kontaktformular, Cloudflare Turnstile, Cookies und Ihre Rechte nach dem Schweizer Datenschutzgesetz.">
	<x-legal-section title="Allgemeines">
		<p>
			Mit dieser Datenschutzerklärung informieren wir darüber, welche Personendaten wir beim Besuch von valtoris.ch und bei einer Kontaktaufnahme bearbeiten, wozu wir das tun und welche Rechte Sie haben. Massgebend ist das Schweizer Bundesgesetz über den Datenschutz (DSG). Soweit im Einzelfall die Datenschutz-Grundverordnung der EU (DSGVO) anwendbar ist, halten wir auch diese ein.
		</p>
		<p>
			Wir bearbeiten nur die Daten, die wir für den Betrieb der Website und die Beantwortung Ihrer Anfragen brauchen. Wir verkaufen keine Daten und setzen weder Analyse- noch Werbedienste ein.
		</p>
	</x-legal-section>

	<x-legal-section title="Verantwortliche Stelle">
		<p>
			{{ $company['name'] }}<br>
			{{ $company['street'] }}<br>
			{{ $company['zip'] }} {{ $company['city'] }}<br>
			Schweiz<br>
			<a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a>
		</p>
		<p>Bei Fragen zum Datenschutz erreichen Sie uns unter dieser Adresse.</p>
	</x-legal-section>

	<x-legal-section title="Hosting und Server-Logfiles">
		<p>
			Diese Website wird bei der {{ $hosting['name'] }}, {{ $hosting['place'] }}, betrieben. Bei jedem Aufruf speichert der Server automatisch technische Angaben in Logfiles: IP-Adresse, Datum und Uhrzeit, aufgerufene Seite, übertragene Datenmenge, die zuvor besuchte Seite (Referrer) sowie Browser und Betriebssystem.
		</p>
		<p>
			Diese Daten brauchen wir, um die Website sicher und stabil zu betreiben und Fehler zu finden. Sie werden nicht mit anderen Daten zusammengeführt und nach spätestens 30 Tagen gelöscht, sofern sie nicht zur Aufklärung eines Sicherheitsvorfalls länger benötigt werden.
		</p>
	</x-legal-section>

	<x-legal-section title="Kontaktformular und E-Mail">
		<p>
			Wenn Sie uns über das Formular schreiben, bearbeiten wir Ihren Vor- und Nachnamen, Ihre E-Mail-Adresse sowie freiwillig Ihre Anrede, Telefonnummer und Nachricht. Wir speichern die Anfrage in der Datenbank der Website und leiten sie per E-Mail an uns weiter. Dasselbe gilt sinngemäss, wenn Sie uns direkt per E-Mail oder Telefon kontaktieren.
		</p>
		<p>
			Wir verwenden diese Angaben ausschliesslich, um Ihre Anfrage zu beantworten und gegebenenfalls eine Zusammenarbeit vorzubereiten. Anfragen, aus denen keine Geschäftsbeziehung entsteht, löschen wir spätestens zwölf Monate nach dem letzten Kontakt.
		</p>
	</x-legal-section>

	<x-legal-section title="Schutz vor Spam: Cloudflare Turnstile">
		<p>
			Zum Schutz des Kontaktformulars vor automatisierten Anfragen setzen wir Turnstile der Cloudflare, Inc., 101 Townsend St., San Francisco, CA 94107, USA, ein. Turnstile prüft, sobald das Kontaktformular in Sicht kommt, anhand technischer Merkmale Ihres Browsers (unter anderem IP-Adresse und Browserangaben), ob eine Anfrage von einem Menschen stammt. Dabei werden keine Cookies zu Werbe- oder Analysezwecken gesetzt.
		</p>
		<p>
			Dabei können Daten in die USA übermittelt werden. Cloudflare ist unter dem Swiss-U.S. Data Privacy Framework zertifiziert. Weitere Informationen finden Sie in der <a href="https://www.cloudflare.com/de-de/privacypolicy/" target="_blank" rel="noopener">Datenschutzerklärung von Cloudflare</a>.
		</p>
	</x-legal-section>

	<x-legal-section title="Cookies und Schriften">
		<p>
			Die Website setzt nur technisch notwendige Cookies: ein Sitzungs-Cookie und ein Sicherheits-Token, die das Kontaktformular vor missbräuchlichen Anfragen schützen. Sie enthalten keine Angaben zu Ihrer Person und werden spätestens nach zwei Stunden ungültig.
		</p>
		<p>
			Die Schrift «Jost» liefern wir von unserem eigenen Server aus. Beim Besuch der Website werden deshalb keine Verbindungen zu Google oder anderen Schriftanbietern aufgebaut.
		</p>
	</x-legal-section>

	<x-legal-section title="Datensicherheit">
		<p>
			Die Übertragung zwischen Ihrem Browser und unserem Server ist mit TLS verschlüsselt. Wir treffen angemessene technische und organisatorische Massnahmen, um Ihre Daten vor Verlust, Missbrauch und unbefugtem Zugriff zu schützen.
		</p>
	</x-legal-section>

	<x-legal-section title="Ihre Rechte">
		<p>
			Sie haben das Recht, Auskunft über die zu Ihrer Person bearbeiteten Daten zu verlangen und deren Berichtigung oder Löschung zu fordern. Sie können der Bearbeitung widersprechen und die Herausgabe Ihrer Daten in einem gängigen elektronischen Format verlangen. Wenden Sie sich dazu an <a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a>.
		</p>
		<p>
			Sind Sie der Ansicht, dass wir Ihre Daten nicht korrekt bearbeiten, können Sie sich an den Eidgenössischen Datenschutz- und Öffentlichkeitsbeauftragten (EDÖB) wenden.
		</p>
	</x-legal-section>

	<x-legal-section title="Änderungen">
		<p>
			Wir passen diese Datenschutzerklärung an, wenn sich die Website oder die rechtlichen Vorgaben ändern. Es gilt die jeweils hier veröffentlichte Fassung.
		</p>
		<p>Stand: November 2026</p>
	</x-legal-section>
</x-legal-page>
