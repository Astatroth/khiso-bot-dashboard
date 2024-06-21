<?php

namespace App\Listeners;

use App\Events\MessageSentEvent;
use App\Services\MessageService;
use App\Services\PostService;

class MessageSentEventListener
{
    /**
     * @param MessageService $messageService
     * @param PostService    $postService
     */
    public function __construct(protected MessageService $messageService, protected PostService $postService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSentEvent $event): void
    {
        $message = $event->getMessage();
        $postId = $event->getPostId();

        $this->postService->markAsSent($postId);

        //$message->delete();
    }
}
