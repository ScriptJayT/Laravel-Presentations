<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\PresentationScriptController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;

// use Laravel\Fortify\Features;
// Features::enabled(Features::registration())

Route::get('/', fn () => Inertia::render('Welcome', ['canRegister' => false]))
    ->name('home');

Route::get('dashboard', [DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('dashboard/presentations', 'dashboard');
Route::redirect('presentations', '/');

Route::controller(PresentationController::class)->group(function () {
    Route::get('/', 'index')
        ->name('home');
    Route::get('presentations/{slug}', 'show')
        ->name('presentations');

    Route::get('dashboard/presentations/{id}', 'edit')
        ->whereNumber('id')
        ->middleware(['auth', 'verified'])
        ->name('admin_presentations')
        ->missing(fn (Request $_) => Redirect::route('dashboard'));
});

Route::controller(PresentationScriptController::class)
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard/scripts/', 'index')
            ->name('admin_script_index');
        Route::get('dashboard/scripts/{id}', 'edit')
            ->whereNumber('id')
            ->name('admin_scripts')
            ->missing(fn (Request $_) => Redirect::route('dashboard'));
    });

require __DIR__.'/settings.php';
