<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\VCardController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::view('/', 'pages.home')->name('home');
Route::view('/impressum', 'pages.impressum')->name('impressum');
Route::view('/datenschutz', 'pages.datenschutz')->name('datenschutz');

Route::get('/visitenkarte/{slug}.vcf', VCardController::class)->name('vcard');

Route::post('/kontakt', [ContactController::class, 'store'])
	->middleware('throttle:5,1')
	->name('contact.store');

// Source page for the Open Graph image; only reachable during local development.
if (app()->isLocal()) {
	Route::view('/og-image', 'og-image');
}
