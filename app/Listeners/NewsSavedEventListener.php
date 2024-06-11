<?php

namespace App\Listeners;

use App\Events\NewsSavedEvent;
use App\Models\Post;
use App\Services\NewsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewsSavedEventListener
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
    public function handle(NewsSavedEvent $event): void
    {
        $dto = $event->getDto();
        $news = (new NewsService())->find($dto->id);

        if (is_null($news->post)) {
            $post = new Post();
            $post->postable()->associate($news);
            $post->save();
        }
    }
}
