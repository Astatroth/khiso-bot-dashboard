<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NewsSavedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param ValidatedDTO $dto
     */
    public function __construct(protected ValidatedDTO $dto)
    {
        //
    }

    /**
     * @return ValidatedDTO
     */
    public function getDto(): ValidatedDTO
    {
        return $this->dto;
    }
}
