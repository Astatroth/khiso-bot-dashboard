<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendConfirmationCodeRequest;
use App\Http\Requests\Api\VerifyConfirmationCode;
use App\Models\ConfirmationCode;
use App\Services\ConfirmationCodeService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfirmationCodeController extends ApiController
{
    /**
     * @param ConfirmationCodeService $confirmationCodeService
     */
    public function __construct(protected ConfirmationCodeService $confirmationCodeService)
    {
        //
    }

    /**
     * @param SendConfirmationCodeRequest $request
     * @return JsonResponse
     */
    public function send(SendConfirmationCodeRequest $request): JsonResponse
    {
        $this->confirmationCodeService->send($request->phone_number, 300);

        return $this->json([]);
    }

    public function verify(VerifyConfirmationCode $request): JsonResponse
    {
        $code = $this->confirmationCodeService->verify($request->phone_number, $request->code);

        return $this->json(compact('code'));
    }
}
