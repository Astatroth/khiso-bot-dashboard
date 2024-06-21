<?php

namespace App\Interfaces\Telegram;

interface HasInlineReplyMarkupInterface
{
    /**
     * @param int|null $studentId
     * @return array|null
     */
    public function inlineMarkup(?int $studentId): array|null;
}
