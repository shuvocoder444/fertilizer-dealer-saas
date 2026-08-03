<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// উদাহরণ: আপনার হোম রাউটটি যদি এমন থাকে
Route::get('/', function (Request $request) {
    if ($request->header('HX-Request')) {
        return view('pages.home-content');
    }
    return view('welcome'); // বা view('pages.home')
})->name('home'); // <-- এই ->name('home') অংশটুকু যুক্ত করুন


// Authenticated Dashboard Routes (Jetstream)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function (Request $request) {
        if ($request->header('HX-Request')) {
            return view('dashboard-content');
        }

        return view('dashboard');
    })->name('dashboard');

});





Route::get('/features', function (Request $request) {
    if ($request->header('HX-Request')) {
        return view('pages.features-content'); // শুধুমাত্র Partial HTML
    }
    return view('pages.features'); // Full Layout
})->name('features');

Route::get('/about', function (Request $request) {
    if ($request->header('HX-Request')) {
        return view('pages.about-content');
    }
    return view('pages.about');
})->name('about');

Route::get('/pricing', function (Request $request) {
    if ($request->header('HX-Request')) {
        return view('pages.pricing-content');
    }
    return view('pages.pricing');
})->name('pricing');
