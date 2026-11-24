<?php

namespace App\Actions\Team;

/**
 * The business card of a team member as a vCard 3.0, built from config/valtoris.php so it
 * always matches the website. vCard wants CRLF line endings and lines of at most 75 octets
 * (longer ones continue on the next line after a space); the portrait goes in as base64.
 */
class BuildVCard
{
	/** @param  array{name: string, role: string, phone: string, email: string, photo: string}  $person */
	public function execute(array $person): string
	{
		$company = config('valtoris.company');
		[$given, $family] = explode(' ', $person['name'], 2) + [1 => ''];

		$lines = [
			'BEGIN:VCARD',
			'VERSION:3.0',
			'N:'.$this->escape($family).';'.$this->escape($given).';;;',
			'FN:'.$this->escape($person['name']),
			'ORG:'.$this->escape($company['name']),
			'TITLE:'.$this->escape($person['role']),
			'TEL;TYPE=CELL,VOICE:'.str_replace(' ', '', $person['phone']),
			'EMAIL;TYPE=INTERNET,WORK:'.$person['email'],
			'ADR;TYPE=WORK:;;'.$this->escape($company['street']).';'.$this->escape($company['city']).';;'.$company['zip'].';Schweiz',
			'URL:https://'.$company['website'],
		];

		$photo = public_path("images/{$person['photo']}-400.jpg");

		if (is_file($photo)) {
			$lines[] = 'PHOTO;ENCODING=b;TYPE=JPEG:'.base64_encode(file_get_contents($photo));
		}

		$lines[] = 'END:VCARD';

		return implode("\r\n", array_map($this->fold(...), $lines))."\r\n";
	}

	private function escape(string $value): string
	{
		return addcslashes($value, '\\,;');
	}

	private function fold(string $line): string
	{
		return implode("\r\n ", mb_str_split($line, 74, '8bit'));
	}
}
