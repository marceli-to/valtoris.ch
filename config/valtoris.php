<?php

/*
 * The content of valtoris.ch: company details, the topic band, the seven services and the team.
 * The pages read it from here, so a phone number or a sentence changes in one place.
 */

return [

	'company' => [
		'name' => 'valtoris gmbh',
		'street' => 'Schlossweg 2',
		'zip' => '7026',
		'city' => 'Maladers',
		'country' => 'CH',
		'email' => 'info@valtoris.ch',
		'website' => 'www.valtoris.ch',
		'tagline' => 'HR · IT · Consulting',
		// The UID from the commercial register, for the Impressum.
		'uid' => 'CHE-210.185.669',
	],

	// Named in the privacy policy. TODO: confirm once the server is known.
	'hosting' => [
		'name' => 'Hostpoint AG',
		'place' => 'Rapperswil-Jona, Schweiz',
	],

	// Where the contact form sends its messages.
	'contact_recipient' => env('VALTORIS_CONTACT_RECIPIENT', 'info@valtoris.ch'),

	// The words in the moving band below the hero; the colours alternate.
	'topics' => [
		'SAP HCM',
		'HR Cloud',
		'Payroll',
		'Zeitwirtschaft',
		'Change',
		'Mensch & Organisation',
	],

	'services' => [
		[
			'title' => "Mensch &\nOrganisation",
			'text' => 'Organisationen sind so stark wie die Menschen, die sie prägen. Deshalb denken wir grundsätzlich in Verbindung von Mensch und Organisation. Wachstum entsteht dort, wo beides miteinander wirkt.',
			'icon' => 'mensch-organisation',
			'colour' => 'plum',
		],
		[
			'title' => 'Zusammenarbeit & Partnerschaft',
			'text' => 'Gemeinsam denken, offen sprechen, entschlossen handeln. Wir glauben an echte Partnerschaft auf Augenhöhe – unkompliziert, ehrlich und pragmatisch.',
			'icon' => 'zusammenarbeit-partnerschaft',
			'colour' => 'verdant',
		],
		[
			'title' => "Kompetenz &\nErfahrung",
			'text' => 'Wir setzen auf Kompetenz statt Bauchgefühl. Was wir tun, können wir – was wir nicht können, lassen wir, und greifen dafür auf ein starkes Netzwerk zurück. Unsere breite HR- und Systemerfahrung macht uns zu verlässlichen Sparringspartnern.',
			'icon' => 'kompetenz-erfahrung',
			'colour' => 'plum',
		],
		[
			'title' => 'Human Resources & Information Technology',
			'text' => 'HR und IT sind unsere Wirkungsfelder. Mit unseren Kunden hinterfragen wir Bestehendes, bringen frischen Wind in HR-Prozesse und setzen gezielt auf moderne Technologien. Das Ziel: mehr Klarheit, mehr Einfachheit, mehr Wirkung.',
			'icon' => 'human-resources-information-technology',
			'colour' => 'verdant',
		],
		[
			'title' => 'Prozesse, Payroll & Zeitwirtschaft',
			'text' => 'Wir finden pragmatische Lösungen für komplexe HR-Prozesse. Payroll und Zeitwirtschaft fordern heraus – genau deshalb beschäftigen wir uns gerne damit. Wir kennen den Charme der Schweizer Payroll und wissen, wie die Uhr in der Zeitwirtschaft tickt.',
			'icon' => 'prozesse-payroll-zeitwirtschaft',
			'colour' => 'plum',
		],
		[
			'title' => "SAP HCM &\nHR Cloud Systeme",
			'text' => 'SAP Human Capital Management? Können wir – und noch mehr. Wir begleiten den Übergang zu modernen HR-Cloud-Lösungen und die Weiterentwicklung bestehender Systeme – ob hybrides Setup oder kompletter Wechsel.',
			'icon' => 'sap-hcm-hr-cloud-systeme',
			'colour' => 'verdant',
		],
		[
			'title' => "Veränderung &\nFokus",
			'text' => 'Erfolgreiche Transformation braucht mehr als neue Prozesse – sie braucht die richtige Einbindung von Menschen und Organisation. Wir gestalten den Wandel aktiv, nachhaltig und zielgerichtet.',
			'icon' => 'veraenderung-fokus',
			'colour' => 'plum',
		],
	],

	// Profile PDFs go to public/downloads; the link only shows once the file is there. The business card
	// (/visitenkarte/{slug}.vcf) is built from these details.
	'team' => [
		[
			'name' => 'Linda Schwerzmann',
			'slug' => 'linda-schwerzmann',
			'role' => 'Partner',
			'phone' => '+41 78 803 43 67',
			'email' => 'linda.schwerzmann@valtoris.ch',
			'quote' => "Ich entwickle\nOrganisationen weiter.",
			'photo' => 'team-linda',
			'profile' => 'downloads/beraterprofil-linda-schwerzmann.pdf',
			'colour' => 'plum',
		],
		[
			'name' => 'Stephan Hugi',
			'slug' => 'stephan-hugi',
			'role' => 'Partner',
			'phone' => '+41 78 403 19 13',
			'email' => 'stephan.hugi@valtoris.ch',
			'quote' => "Ich verbinde Menschen\nund Technologie.",
			'photo' => 'team-stephan',
			'profile' => 'downloads/beraterprofil-stephan-hugi.pdf',
			'colour' => 'verdant',
		],
	],

];
