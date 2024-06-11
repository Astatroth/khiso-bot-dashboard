<?php

namespace App\Traits;

trait StatusTrait
{
    const STATUS_QUEUED = 1;
    const STATUS_SENDING = 2;
    const STATUS_SENT = 3;
    const STATUS_FAILED = -1;
}
