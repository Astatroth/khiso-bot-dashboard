<?php

namespace App\Interfaces\Telegram;

interface HasInlineReplyMarkupInterface
{
    /**
     * @return array
     */
    public function inlineMarkup(): array;
}
