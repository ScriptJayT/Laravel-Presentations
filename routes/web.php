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

Route::redirect('dashboard/presentations', 'dashboard');
Route::redirect('presentations', '/');

Route::controller(PresentationController::class)->group(function() {
    Route::get('/', 'index')
        ->name('home');
    Route::get('presentations/{slug}', "show")
        ->whereAlpha('slug')
        ->name('presentations');

    Route::get('dashboard/presentations/{id}', "edit")
        ->whereNumber('id')
        ->middleware(['auth', 'verified'])
        ->name('admin_presentations')
        ->missing(fn (Request $_) => Redirect::route('dashboard'));
});


require __DIR__.'/settings.php';
