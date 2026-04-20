<?php

use App\Http\Controllers\AdminPresentationController;
use App\Http\Controllers\AdminPresentationScriptController;
use App\Http\Controllers\AdminPresentationSlideController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Presentations\PresentationController;
use App\Http\Controllers\Presentations\PresentationScriptController;
use App\Http\Controllers\Roles\AdminPermissionController;
use App\Http\Controllers\Roles\AdminRolesController;
use App\Http\Controllers\Settings\AdminPasswordResetController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        Route::get('/', fn () => Inertia::render('dashboard/Welcome'))
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
            ->middlewareFor(['create', 'store'], 'can:create users')
            ->middlewareFor(['index', 'show'], 'can:read users')
            ->middlewareFor(['edit', 'update'], 'can:update users')
            ->middlewareFor('destroy', 'can:delete users')
            ->except(['create'])
            ->names([
                'index' => 'admin_user_index',
                'show' => 'admin_user.show',
                'destroy' => 'admin_user.destroy',
                'store' => 'admin_user.store',
                'edit' => 'admin_user.edit',
                'update' => 'admin_user.update',
            ])
            ->missing(fn () => Redirect::route('admin_user_index'));
        Route::resource('roles', AdminRolesController::class)
            ->middleware('can:primordial')
            ->withoutMiddlewareFor('index', 'can:primordial')
            ->only(['index', 'edit', 'update'])
            ->names([
                'index' => 'admin_role_index',
                'edit' => 'admin_role.edit',
                'update' => 'admin_role.update',
            ]);
        Route::resource('permissions', AdminPermissionController::class)
            ->middleware('can:primordial')
            ->only(['edit', 'update'])
            ->names([
                'edit' => 'admin_permission.edit',
                'update' => 'admin_permission.update',
            ]);

        Route::post('password-reset', [AdminPasswordResetController::class, 'store'])
            ->name('send_password');
    });

require __DIR__.'/settings.php';
