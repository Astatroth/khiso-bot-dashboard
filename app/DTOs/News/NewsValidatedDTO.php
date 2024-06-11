<?php

namespace App\DTOs\News;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NewsValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:news,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'url' => 'nullable|url',
            'media' => 'nullable|array'
        ];

        // TODO: добавить проверку соответствия типа и ссылки
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
