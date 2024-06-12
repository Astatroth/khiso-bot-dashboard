<?php

namespace App\Listeners;

use App\Events\OlympiadSavedEvent;
use App\Models\Post;
use App\Services\OlympiadService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OlympiadSavedEventListener
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
    public function handle(OlympiadSavedEvent $event): void
    {
        $dto = $event->getDto();
        $model = (new OlympiadService())->find($dto->id);

        if (is_null($model->post)) {
            $post = new Post();
            $post->postable()->associate($model);
            $post->save();
        }
    }
}
