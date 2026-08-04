<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/features', function () {
    return view('pages.features');
})->name('features');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/pricing', function () {
    return view('pages.pricing');
})->name('pricing');


// প্রটেক্টেড ড্যাশবোর্ড রাউট
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});
