<?php

namespace App\DTOs\Telegram;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ChannelValidatedDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'id' => 'sometimes|integer|exists:telegram_channels,id',
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'channel_id' => 'required|integer'
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
