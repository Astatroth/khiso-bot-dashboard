<?php

namespace App\Events;

use App\DTOs\Olympiad\OlympiadDTO;
use App\Models\Olympiad;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OlympiadEndedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(protected Olympiad $olympiad)
    {
        //
    }

    /**
     * @return OlympiadDTO
     */
    public function getOlympiad(): Olympiad
    {
        return $this->olympiad;
    }
}
