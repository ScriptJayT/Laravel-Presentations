<?php

use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use Laravel\Fortify\Features;
// Features::enabled(Features::registration())

Route::get('/', fn() => Inertia::render('Welcome', [ 'canRegister' => false ]))
    ->name('home');

Route::get('dashboard', [DashboardController::class, "show"])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
