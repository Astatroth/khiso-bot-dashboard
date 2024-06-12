<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OlympiadSignUpRequest;
use App\Http\Requests\RegisterAnswerRequest;
use App\Http\Requests\StartOlympiadRequest;
use App\Services\OlympiadService;
use App\Services\QuestionService;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class OlympiadController extends ApiController
{
    /**
     * @param OlympiadService $olympiadService
     * @param StudentService  $studentService
     * @param QuestionService $questionService
     */
    public function __construct(
        protected OlympiadService $olympiadService,
        protected StudentService $studentService,
        protected QuestionService $questionService
    ) {
        //
    }

    /**
     * @param int $olympiadId
     * @param int $studentId
     * @param int $questionNumber
     * @return JsonResponse
     */
    public function getQuestion(int $olympiadId, int $studentId, int $questionNumber)
    {
        if (!$this->olympiadService->checkOlympiadStatus($olympiadId)) {
            $this->error($this->olympiadService->getFailReason());

            return $this->json([]);
        }

        $result = $this->olympiadService->getResults($olympiadId, $studentId);
        $question = $this->questionService->getQuestionByNumber($olympiadId, $questionNumber, $result);

        if (!$question instanceof ValidatedDTO) {
            $this->error($question);

            return $this->json([]);
        }

        return $this->json([
            'question' => $question
        ]);
    }

    public function registerAnswer(RegisterAnswerRequest $request): JsonResponse
    {
        $result = $this->questionService->registerAnswer(
            $request->question_id,
            $request->answer_id,
            $request->student_id
        );

        if ($result !== true) {
            $this->error($result);
        }

        return $this->json([]);
    }

    /**
     * @param OlympiadSignUpRequest $request
     * @return JsonResponse
     */
    public function signUp(OlympiadSignUpRequest $request): JsonResponse
    {
        $result = $this->olympiadService->signUp($request->olympiad_id, $request->student_id);

        if (!$result) {
            $this->error($this->olympiadService->getSignUpFailReason());
        }

        return $this->json([]);
    }

    /**
     * @param StartOlympiadRequest $request
     * @return JsonResponse
     */
    public function start(StartOlympiadRequest $request): JsonResponse
    {
        $result = $this->olympiadService->start($request->olympiad_id, $request->student_id);

        if (!$result) {
            $this->error($this->olympiadService->getStartFailReason());
        }

        $olympiad = $this->olympiadService->find($request->olympiad_id);

        return $this->json([
            'message' => __("You have :limit minutes to answer all the questions", ['limit' => $olympiad->time_limit])
        ]);
    }
}
