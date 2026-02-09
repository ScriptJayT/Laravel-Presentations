<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresentationController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Redirect;
// use Laravel\Fortify\Features;
// Features::enabled(Features::registration())

Route::get('/', fn() => Inertia::render('Welcome', [ 'canRegister' => false ]))
    ->name('home');

Route::get('dashboard', [DashboardController::class, "show"])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/presentation/{id}', [PresentationController::class, "edit"])
    ->middleware(['auth', 'verified'])
    ->name('presentations')
    ->missing(fn (Request $request) => Redirect::route('dashboard'));

require __DIR__.'/settings.php';
