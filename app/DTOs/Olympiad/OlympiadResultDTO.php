<?php

namespace App\DTOs\Olympiad;

use App\Traits\DTOTrait;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class OlympiadResultDTO extends ValidatedDTO
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
