<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OlympiadSignUpRequest;
use App\Services\OlympiadService;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OlympiadController extends ApiController
{
    /**
     * @param OlympiadService $olympiadService
     * @param StudentService  $studentService
     */
    public function __construct(protected OlympiadService $olympiadService, protected StudentService $studentService)
    {
        //
    }

    /**
     * @param OlympiadSignUpRequest $request
     * @return JsonResponse
     */
    public function signUp(OlympiadSignUpRequest $request)
    {
        $result = $this->olympiadService->signUp($request->olympiad_id, $request->student_id);

        if (!$result) {
            $this->error($this->olympiadService->getSignUpFailReason());
        }

        return $this->json([]);
    }
}
