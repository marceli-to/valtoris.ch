<?php

namespace Tests\Feature;

use Tests\TestCase;

class VCardTest extends TestCase
{
	public function test_each_team_member_has_a_business_card(): void
	{
		foreach (config('valtoris.team') as $person) {
			$response = $this->get(route('vcard', $person['slug']))
				->assertOk()
				->assertHeader('Content-Type', 'text/vcard; charset=UTF-8')
				->assertHeader('Content-Disposition', 'attachment; filename="'.$person['name'].'.vcf"');

			// Unfold continued lines before looking at the fields.
			$card = str_replace("\r\n ", '', $response->getContent());

			$this->assertStringStartsWith("BEGIN:VCARD\r\nVERSION:3.0\r\n", $card);
			$this->assertStringContainsString("FN:{$person['name']}\r\n", $card);
			$this->assertStringContainsString('TEL;TYPE=CELL,VOICE:'.str_replace(' ', '', $person['phone'])."\r\n", $card);
			$this->assertStringContainsString("EMAIL;TYPE=INTERNET,WORK:{$person['email']}\r\n", $card);
			$this->assertStringContainsString("ORG:valtoris gmbh\r\n", $card);
			$this->assertStringEndsWith("END:VCARD\r\n", $card);

			foreach (explode("\r\n", $response->getContent()) as $line) {
				$this->assertLessThanOrEqual(75, strlen($line));
			}
		}
	}

	public function test_unknown_person_is_not_found(): void
	{
		$this->get('/visitenkarte/niemand.vcf')->assertNotFound();
	}

	public function test_team_section_links_the_business_cards(): void
	{
		$response = $this->get('/')->assertOk();

		foreach (config('valtoris.team') as $person) {
			$response->assertSee(route('vcard', $person['slug']), false);
		}
	}
}
