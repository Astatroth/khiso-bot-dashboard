<?php

namespace App\Events;

use App\DTOs\Olympiad\OlympiadDTO;
use App\Models\Olympiad;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OlympiadStartedEvent
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
