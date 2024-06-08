<?php

namespace App\Providers;

use App\Overrides\AuthUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Auth::provider('user', function ($app, array $config) {
            return new AuthUserProvider($app['hash'], $config['model']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
