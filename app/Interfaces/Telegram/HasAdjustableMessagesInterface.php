<?php

namespace App\Interfaces\Telegram;

interface HasAdjustableMessagesInterface
{
    /**
     * @return string
     */
    public function message(): string;
}
