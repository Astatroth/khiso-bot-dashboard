<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class ApiController
{
    /**
     * @var int
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @param string   $error
     * @param int|null $code
     * @return void
     */
    protected function error(string $error, int|null $code = null): void
    {
        $this->errorMessage = $error;
        $this->errorCode = $code;
    }

    /**
     * @param array $payload
     * @param int   $status
     * @param array $headers
     * @param int   $options
     * @return JsonResponse
     */
    protected function json(array $payload, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        $payload = array_merge($payload, [
            'status' => $this->errorMessage ? 0 : 1
        ]);

        if ($this->errorMessage) {
            $payload['error'] = [
                'message' => $this->errorMessage
            ];

            if ($this->errorCode) {
                $payload['error']['code'] = $this->errorCode;
            }
        }

        return response()->json($payload, $status, $headers, $options);
    }
}
