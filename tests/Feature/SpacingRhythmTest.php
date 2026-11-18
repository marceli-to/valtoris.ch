<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Padding, margin, gaps and scroll offsets follow a 4px rhythm. One spacing step is 1px
 * (px-12 is 12px), so the theme can't enforce it; this test does. Element sizes (w-, h-,
 * size-) aren't checked: the logo, the burger bars and the pattern tile keep their artwork sizes.
 */
class SpacingRhythmTest extends TestCase
{
	private const SPACING = '(?:p|px|py|pt|pr|pb|pl|ps|pe|m|mx|my|mt|mr|mb|ml|ms|me|gap|gap-x|gap-y|space-x|space-y|scroll-m|scroll-mx|scroll-my|scroll-mt|scroll-mr|scroll-mb|scroll-ml|scroll-p|scroll-px|scroll-py|scroll-pt|scroll-pr|scroll-pb|scroll-pl)';

	public function test_spacing_utilities_are_multiples_of_four(): void
	{
		$files = collect(File::allFiles(resource_path('views')))
			->push(new \SplFileInfo(resource_path('css/app.css')));

		$offGrid = [];

		foreach ($files as $file) {
			foreach (file($file->getPathname()) as $number => $line) {
				// A utility, optionally behind variants (md:, hover:) and a minus sign: md:-mt-10, gap-x-32.
				preg_match_all('/(?<![\w\[-])(?:[\w-]+:)*-?'.self::SPACING.'-(\d+)(?![\w.\/\]-])/', $line, $matches, PREG_SET_ORDER);

				foreach ($matches as [$utility, $value]) {
					if ((int) $value % 4 !== 0) {
						$offGrid[] = str_replace(resource_path().'/', '', $file->getPathname()).':'.($number + 1).'  '.$utility;
					}
				}
			}
		}

		$this->assertSame([], $offGrid, "Spacing off the 4px grid:\n".implode("\n", $offGrid));
	}
}
