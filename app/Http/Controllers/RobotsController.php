<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/** robots.txt: crawlers welcome on production only; local and staging keep them out. */
class RobotsController extends Controller
{
	public function __invoke(): Response
	{
		return response()
			->view('robots', ['indexable' => app()->isProduction()])
			->header('Content-Type', 'text/plain; charset=UTF-8');
	}
}
