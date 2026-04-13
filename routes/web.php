<?php

use App\Http\Controllers\AdminPresentationController;
use App\Http\Controllers\AdminPresentationScriptController;
use App\Http\Controllers\AdminPresentationSlideController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\PresentationScriptController;
use App\Http\Controllers\Settings\AdminPasswordResetController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

// use Laravel\Fortify\Features;
// Features::enabled(Features::registration())

Route::redirect('presentations', '/');
Route::redirect('p', '/');
Route::controller(PresentationController::class)->group(function () {
    Route::get('/', 'index')
        ->name('home');
    Route::get('p/{presentation:slug}', 'show')
        ->name('presentations')
        ->missing(fn () => Redirect::route('home'));
    Route::get('presentations/{presentation:slug}', 'show')
        ->missing(fn () => Redirect::route('home'));
});
Route::redirect('scripts', '/');
Route::redirect('s', '/');
Route::controller(PresentationScriptController::class)->group(function () {
    Route::get('/s/{script}', 'show')
        ->name('scripts');
    Route::get('/scripts/{script}', 'show');
});

Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', fn () => Redirect::route('admin_presentation_index'))
            ->name('dashboard');

        Route::resource('presentations', AdminPresentationController::class)
            ->middleware('can:crud presentations')
            ->except(['show', 'create'])
            ->names([
                'index' => 'admin_presentation_index',
                'edit' => 'admin_presentations',
                'destroy' => 'admin_presentation.destroy',
                'store' => 'admin_presentation.store',
                'update' => 'admin_presentation.update',
            ])
            ->missing(fn () => Redirect::route('admin_presentation_index'));
        Route::resource('slides', AdminPresentationSlideController::class)
            ->middleware('can:crud presentations')
            ->only(['destroy', 'store', 'update'])
            ->names([
                'destroy' => 'admin_slide.destroy',
                'store' => 'admin_slide.store',
                'update' => 'admin_slide.update',
            ])
            ->missing(fn () => Redirect::route('admin_presentation_index'));

        Route::resource('scripts', AdminPresentationScriptController::class)
            ->middleware('can:crud presentations')
            ->except(['show', 'create'])
            ->names([
                'index' => 'admin_script_index',
                'edit' => 'admin_scripts',
                'destroy' => 'admin_script.destroy',
                'store' => 'admin_script.store',
                'update' => 'admin_script.update',
            ])
            ->missing(fn () => Redirect::route('admin_script_index'));

        Route::resource('users', AdminUserController::class)
            ->middleware('can:read users')
            ->except(['create'])
            ->names([
                'index' => 'admin_user_index',
                'show' => 'admin_user.show',
                'edit' => 'admin_user.edit',
                'destroy' => 'admin_user.destroy',
                'store' => 'admin_user.store',
                'update' => 'admin_user.update',
            ])
            ->missing(fn () => Redirect::route('admin_user_index'));
        Route::post('password-reset', [AdminPasswordResetController::class, 'store'])
            ->name('send_password');
    });

require __DIR__.'/settings.php';
