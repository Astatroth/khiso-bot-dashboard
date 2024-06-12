<?php

namespace App\Interfaces\Telegram;

interface HasAdjustableMessagesInterface
{
    /**
     * @param int|null $studentId
     * @return string
     */
    public function message(?int $studentId): string;
}
