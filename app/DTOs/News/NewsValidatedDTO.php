<?php

namespace App\DTOs\News;

use App\Models\NewsMedia;
use App\Rules\MediaTypeUrl;
use App\Rules\UrlScheme;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NewsValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:news,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'media' => ['nullable', 'array', new UrlScheme('src'), new MediaTypeUrl([
                'photo' => NewsMedia::TYPE_PHOTO,
                'video' => NewsMedia::TYPE_VIDEO
            ])]
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
