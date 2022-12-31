<?php

use App\Http\Controllers\PublicController;
use Inertia\Inertia;


Route::controller(PublicController::class)->group(function () {
  // index
  Route::get('/', 'index')->name('index');
});

Route::get('/about', function () {

	return Inertia::render('About');
})->name('about');

Route::get('/contact-us', function () {
	return Inertia::render('ContactUs');
})->name('contact-us');
