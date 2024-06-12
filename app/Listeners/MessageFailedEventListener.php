<?php

namespace App\Listeners;

use App\Events\MessageFailedEvent;
use App\Services\MessageService;
use App\Services\PostService;

class MessageFailedEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected MessageService $messageService, protected PostService $postService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageFailedEvent $event): void
    {
        $message = $event->getMessage();

        $this->postService->markAsFailed($message->post_id);

        //$message->delete();
    }
}
