<?php

namespace App\Providers;

use App\Console\Commands\DispatchMessages;
use App\Overrides\AuthUserProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
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
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(DispatchMessages::class)->everyMinute()->withoutOverlapping();
        });
    }
}
