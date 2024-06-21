<?php

namespace App\Pipes;

use App\Events\MessageDispatchEvent;
use App\Models\Post;
use App\Models\Student;
use App\Services\MessageService;
use Illuminate\Support\Collection;

class DispatchPipe
{
    /**
     * @var array<string>
     */
    protected $sendItems = [];

    /**
     * @param MessageService $messageService
     */
    public function __construct(protected MessageService $messageService)
    {

    }

    /**
     * @param string $key
     * @return void
     */
    protected function appendItem(string $key): void
    {
        $this->sendItems[] = $key;
    }

    /**
     * @param int $postId
     * @param int $recipientId
     * @return bool
     */
    protected function canSendToRecipient(int $postId, int $recipientId): bool
    {
        $key = $postId.' - '.$recipientId;

        if (in_array($key, $this->sendItems, true)) {
            return false;
        }

        $this->appendItem($key);

        return true;
    }

    /**
     * @param Post    $post
     * @param Student $recipient
     * @return void
     */
    protected function dispatch(Post $post, Student $recipient): void
    {
        $message = $this->messageService->compileMessage($post, $post->postable, $recipient);

        if ($message) {
            \Log::info(" - message with id {$message->id} compiled");
        }

        event(new MessageDispatchEvent($post->id, $message));
    }

    /**
     * @param Post       $post
     * @param Collection $recipients
     * @return void
     */
    protected function dispatchToRecipient(Post $post, Collection $recipients): void
    {
        \Log::info(" - number of recipients int the current chunk: {$recipients->count()}");

        foreach ($recipients as $recipient) {
            if (!$this->canSendToRecipient($post->id, $recipient->id)) {
                continue;
            }

            $this->dispatch($post, $recipient);
        }
    }

    /**
     * @param Post $post
     * @param      $next
     * @return mixed
     */
    public function handle(Post $post, $next)
    {
        $this->handleRecipients($post);

        return $next($post);
    }

    /**
     * @param Post $post
     * @return void
     */
    protected function handleRecipients(Post $post): void
    {
        Student::chunkById(10, function ($students) use ($post) {
            $this->dispatchToRecipient($post, $students);
        }, 'id');
    }
}
