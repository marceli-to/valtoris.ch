<?php

namespace App\Http\Controllers;

use App\Actions\Team\BuildVCard;
use Illuminate\Http\Response;

/** The business card (.vcf) of a team member, linked as «Visitenkarte» in the team section. */
class VCardController extends Controller
{
	public function __invoke(string $slug, BuildVCard $buildVCard): Response
	{
		$person = collect(config('valtoris.team'))->firstWhere('slug', $slug) ?? abort(404);

		return response($buildVCard->execute($person))
			->header('Content-Type', 'text/vcard; charset=UTF-8')
			->header('Content-Disposition', 'attachment; filename="'.$person['name'].'.vcf"');
	}
}
