<?php

namespace App\Events;

use App\Models\PostMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageFailedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param PostMessage $message
     */
    public function __construct(protected PostMessage $message)
    {
        //
    }

    /**
     * @return PostMessage
     */
    public function getMessage(): PostMessage
    {
        return $this->message;
    }
}
