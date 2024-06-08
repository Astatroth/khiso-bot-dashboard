<?php

namespace App\Http\Controllers\Api;

use App\Services\TelegramChannelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramChannelController extends ApiController
{
    /**
     * @param TelegramChannelService $service
     */
    public function __construct(protected TelegramChannelService $service)
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $channels = $this->service->getChannels();

        return $this->json(compact('channels'));
    }
}
