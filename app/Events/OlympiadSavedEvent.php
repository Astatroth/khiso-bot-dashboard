<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class OlympiadSavedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
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
