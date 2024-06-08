<?php

namespace App\DTOs\Telegram;

use App\Traits\DTOTrait;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ChannelDTO extends ValidatedDTO
{
    use DTOTrait;

    protected function rules(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
