<?php

namespace App\Events;

use App\Models\PostMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDispatchEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param int              $postId
     * @param PostMessage|null $message
     */
    public function __construct(protected int $postId, protected ?PostMessage $message)
    {
        //
    }

    /**
     * @return PostMessage
     */
    public function getMessage(): PostMessage|null
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }
}
