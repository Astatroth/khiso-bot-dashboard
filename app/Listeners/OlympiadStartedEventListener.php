<?php

namespace App\Listeners;

use App\Events\OlympiadStartedEvent;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OlympiadStartedEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OlympiadStartedEvent $event): void
    {
        $model = $event->getOlympiad();

        if (is_null($model->post)) {
            $post = new Post();
            $post->postable()->associate($model);
            $post->save();
        } else {
            $model->post()->update([
                'status' => Post::STATUS_QUEUED
            ]);
        }
    }
}
