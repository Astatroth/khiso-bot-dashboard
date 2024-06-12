<?php

namespace App\DTOs\Olympiad;

use App\Rules\Image;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class OlympiadValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:olympiads,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:745',
            'image' => [
                'required_without:current_image', 'file', new Image('jpg,jpeg,png,webp')
            ],
            'current_image' => 'nullable|string',
            'starts_at' => 'required|string',
            'ends_at' => 'required|string',
            'time_limit' => 'required|integer|min:10'
        ];
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
