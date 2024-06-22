<?php

namespace App\Events;

use App\Models\PostMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param int              $postId
     * @param PostMessage|null $message
     */
    public function __construct(protected ?PostMessage $message)
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
}
