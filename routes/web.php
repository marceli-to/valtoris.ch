<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/impressum', 'pages.impressum')->name('impressum');
Route::view('/datenschutz', 'pages.datenschutz')->name('datenschutz');

Route::post('/kontakt', [ContactController::class, 'store'])
	->middleware('throttle:5,1')
	->name('contact.store');

// Source page for the Open Graph image; only reachable during local development.
if (app()->isLocal()) {
	Route::view('/og-image', 'og-image');
}
