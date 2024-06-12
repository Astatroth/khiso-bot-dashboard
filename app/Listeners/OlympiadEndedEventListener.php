<?php

namespace App\Listeners;

use App\Events\OlympiadEndedEvent;
use App\Models\Post;
use App\Services\OlympiadService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OlympiadEndedEventListener
{
    /**
     * @param OlympiadService $olympiadService
     */
    public function __construct(protected OlympiadService $olympiadService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OlympiadEndedEvent $event): void
    {
        $model = $event->getOlympiad();
        $this->olympiadService->calculateScore($model->id);

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
