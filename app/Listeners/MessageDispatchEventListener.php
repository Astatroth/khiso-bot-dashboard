<?php

namespace App\Listeners;

use App\Events\MessageDispatchEvent;
use App\Events\MessageFailedEvent;
use App\Events\MessageSentEvent;
use App\Modules\Telegram\TelegramException;
use App\Services\MessageService;
use App\Services\PostService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageDispatchEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var int
     */
    public $delay = 10;

    /**
     * @var string
     */
    public $queue = 'post-message-dispatch-queue';

    /**
     * @param MessageService $messageService
     * @param PostService    $postService
     */
    public function __construct(protected MessageService $messageService, protected PostService $postService)
    {
        //
    }

    /**
     * @param MessageDispatchEvent $event
     * @return void
     */
    public function handle(MessageDispatchEvent $event): void
    {
        sleep(10);

        $message = $event->getMessage();
        $postId = $event->getPostId();

        try {
            if ($message) {
                \Log::info(" - sending message id: {$message->id}");

                $this->messageService->sendMessage($message);
            }

            event(new MessageSentEvent($postId, $message));
        } catch (\Exception $e) {
            // void
        }
    }
}
