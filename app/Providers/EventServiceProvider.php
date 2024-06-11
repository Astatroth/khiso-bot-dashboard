<?php

namespace App\Providers;

use App\Events\MessageDispatchEvent;
use App\Events\MessageFailedEvent;
use App\Events\MessageSentEvent;
use App\Events\NewsSavedEvent;
use App\Listeners\MessageDispatchEventListener;
use App\Listeners\MessageFailedEventListener;
use App\Listeners\MessageSentEventListener;
use App\Listeners\NewsSavedEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        NewsSavedEvent::class => [
            NewsSavedEventListener::class
        ],
        MessageDispatchEvent::class => [
            MessageDispatchEventListener::class
        ],
        MessageSentEvent::class => [
            MessageSentEventListener::class
        ],
        MessageFailedEvent::class => [
            MessageFailedEventListener::class
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
