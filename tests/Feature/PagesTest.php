<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
	public function test_home_page_shows_every_section(): void
	{
		$this->get('/')
			->assertOk()
			->assertSee('id="leistungen"', false)
			->assertSee('id="gesundheitswesen"', false)
			->assertSee('id="team"', false)
			->assertSee('id="kontakt"', false)
			->assertSee('Was wir bewegen.')
			->assertSee('Linda Schwerzmann')
			->assertSee('Stephan Hugi')
			->assertSee('challenges.cloudflare.com/turnstile', false)
			->assertSee('data-sitekey="'.config('services.turnstile.site_key').'"', false);
	}

	public function test_home_page_lists_all_seven_services(): void
	{
		$response = $this->get('/')->assertOk();

		foreach (config('valtoris.services') as $service) {
			$response->assertSee(str_replace("\n", "<br>\n", e($service['title'])), false);
		}
	}

	public function test_legal_pages_render(): void
	{
		$this->get('/impressum')->assertOk()->assertSee('Verantwortlich für den Inhalt')->assertSee('Maladers');
		$this->get('/datenschutz')->assertOk()->assertSee('Datenschutzerklärung')->assertSee('Cloudflare Turnstile');
	}

	public function test_pages_carry_canonical_and_share_tags(): void
	{
		config(['app.url' => 'https://valtoris.ch']);

		$this->get('/impressum')
			->assertSee('<link rel="canonical" href="https://valtoris.ch/impressum">', false)
			->assertSee('property="og:image" content="'.asset('images/og.png').'"', false)
			->assertSee('application/ld+json', false);
	}

	public function test_profile_link_only_shows_when_the_pdf_exists(): void
	{
		foreach (config('valtoris.team') as $person) {
			$response = $this->get('/');

			file_exists(public_path($person['profile']))
				? $response->assertSee($person['profile'], false)
				: $response->assertDontSee($person['profile'], false);
		}
	}

	public function test_og_image_source_is_not_public(): void
	{
		$this->assertFalse(app()->isLocal());
		$this->get('/og-image')->assertNotFound();
	}

	public function test_static_files_for_search_engines_exist(): void
	{
		foreach (['robots.txt', 'sitemap.xml', 'llms.txt', 'site.webmanifest', 'favicon.ico', 'favicon.svg', 'apple-touch-icon.png'] as $file) {
			$this->assertFileExists(public_path($file));
		}

		$this->assertStringContainsString('Sitemap: https://valtoris.ch/sitemap.xml', file_get_contents(public_path('robots.txt')));
	}

	public function test_every_photo_variant_is_rendered(): void
	{
		$images = json_decode(file_get_contents(resource_path('images/images.json')), true);

		foreach ($images as $name => $image) {
			if (str_starts_with($name, '_')) {
				continue;
			}

			foreach ($image['widths'] as $width) {
				foreach (['avif', 'webp', 'jpg'] as $extension) {
					$this->assertFileExists(public_path("images/{$name}-{$width}.{$extension}"), 'Run npm run images.');
				}
			}
		}
	}
}
