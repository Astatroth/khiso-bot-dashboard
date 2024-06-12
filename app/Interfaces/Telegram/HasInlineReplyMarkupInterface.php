<?php

namespace App\Interfaces\Telegram;

interface HasInlineReplyMarkupInterface
{
    /**
     * @return array|null
     */
    public function inlineMarkup(): array|null;
}
