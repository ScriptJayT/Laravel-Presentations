<?php

use App\Http\Controllers\AdminPresentationController;
use App\Http\Controllers\AdminPresentationScriptController;
use App\Http\Controllers\PresentationController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

// use Laravel\Fortify\Features;
// Features::enabled(Features::registration())

Route::redirect('presentations', '/');
Route::controller(PresentationController::class)->group(function () {
    Route::get('/', 'index')
        ->name('home');
    Route::get('presentations/{slug}', 'show')
        ->name('presentations');
});

Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', fn () => Redirect::route('admin_presentation_index'))
            ->name('dashboard');

        Route::controller(AdminPresentationController::class)
            ->group(function () {
                Route::get('/presentations', 'index')
                    ->name('admin_presentation_index');
                Route::get('/presentations/{id}', 'edit')
                    ->whereNumber('id')
                    ->name('admin_presentations')
                    ->missing(fn (Request $_) => Redirect::route('admin_presentation_index'));
            });

        Route::controller(AdminPresentationScriptController::class)
            ->group(function () {
                Route::get('/scripts', 'index')
                    ->name('admin_script_index');
                Route::get('/scripts/{id}', 'edit')
                    ->whereNumber('id')
                    ->name('admin_scripts')
                    ->missing(fn (Request $_) => Redirect::route('admin_presentation_index'));
            });
    });

require __DIR__.'/settings.php';
