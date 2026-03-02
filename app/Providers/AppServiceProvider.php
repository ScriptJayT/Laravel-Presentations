<?php

namespace App\Providers;

use App\Enums\Visibility;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        Inertia::share([
            'appName' => config('app.name'),
            'enums' => [
                'visibility' => [
                    'PUBLIC' => Visibility::PUBLIC->title(),
                    'PROTECTED' => Visibility::PROTECTED->title(),
                    'PRIVATE' => Visibility::PRIVATE->title(),
                ],
            ],
            'flash' => fn () => [
                'success' => session('success'),
                'error' => session('error'),
                'info' => session('info'),
            ],
        ]);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
