<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//    return Inertia::render('Welcome');
// })->name('home');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', function () {
    return redirect()->route('filament.alpha.auth.login');
})->name('login');

// Route::get('dashboard', function () {
//    return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//
// require __DIR__ . '/settings.php';
// require __DIR__ . '/auth.php';
