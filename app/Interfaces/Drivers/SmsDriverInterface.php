<?php

namespace App\Interfaces\Drivers;

interface SmsDriverInterface
{
    /**
     * @param string $phoneNumber
     * @param string $message
     * @return void
     */
    public function sendMessage(string $phoneNumber, string $message): void;
}
