<?php

namespace App\Providers;

use App\Events\MessageDispatchEvent;
use App\Events\MessageFailedEvent;
use App\Events\MessageSentEvent;
use App\Events\NewsSavedEvent;
use App\Events\OlympiadEndedEvent;
use App\Events\OlympiadSavedEvent;
use App\Events\OlympiadStartedEvent;
use App\Listeners\MessageDispatchEventListener;
use App\Listeners\MessageFailedEventListener;
use App\Listeners\MessageSentEventListener;
use App\Listeners\NewsSavedEventListener;
use App\Listeners\OlympiadEndedEventListener;
use App\Listeners\OlympiadSavedEventListener;
use App\Listeners\OlympiadStartedEventListener;
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
        ],
        OlympiadSavedEvent::class => [
            OlympiadSavedEventListener::class
        ],
        OlympiadStartedEvent::class => [
            OlympiadStartedEventListener::class
        ],
        OlympiadEndedEvent::class => [
            OlympiadEndedEventListener::class
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
