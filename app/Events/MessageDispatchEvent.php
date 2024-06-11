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
