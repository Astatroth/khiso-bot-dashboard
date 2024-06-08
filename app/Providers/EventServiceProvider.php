<?php

namespace App\Providers;

use App\Events\PageDeletedEvent;
use App\Events\PageSavedEvent;
use App\Listeners\EntityDeletedEventListener;
use App\Listeners\EntitySavedEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PageDeletedEvent::class => [
            EntityDeletedEventListener::class
        ],
        PageSavedEvent::class => [
            EntitySavedEventListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
