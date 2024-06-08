<?php

namespace App\Services;

use App\Interfaces\Drivers\SmsDriverInterface;

class SmsService
{
    /**
     * @var SmsDriverInterface
     */
    protected $driver;

    /**
     * SmsService constructor.
     */
    public function __construct()
    {
        $driver = config('sms.driver');

        if (!is_null($driver)) {
            $class = config('sms.drivers')[$driver]['class'];
            $this->driver = new $class(
                config('sms.drivers.'.$driver.'.login'),
                config('sms.drivers.'.$driver.'.password'),
                config('sms.drivers.'.$driver.'.endpoint')
            );
        }
    }

    /**
     * @param string $number
     * @param string $message
     */
    public function sendMessage(string $number, string $message): void
    {
        $this->driver->sendMessage($number, $message);
    }
}
