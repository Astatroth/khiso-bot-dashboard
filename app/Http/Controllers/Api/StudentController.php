<?php

namespace App\Http\Controllers\Api;


use App\DTOs\Student\StudentValidatedDTO;
use App\Models\User;
use App\Services\ConfirmationCodeService;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class StudentController extends ApiController
{
    /**
     * @param StudentService $studentService
     */
    public function __construct(protected StudentService $studentService)
    {
        //
    }

    /**
     * @param StudentValidatedDTO $dto
     * @return JsonResponse
     */
    public function create(StudentValidatedDTO $dto): JsonResponse
    {
        \DB::transaction(function () use ($dto) {
            $userExists = User::where('phone', $dto->phone_number)->exists();

            if (!$userExists) {
                $user = (new UserService())->create(
                    $dto->full_name,
                    'student_'.md5(uniqid().time()),
                    \Str::random(16),
                    phone: $dto->phone_number
                );
                $this->studentService->create($dto, $user->id);
                (new ConfirmationCodeService())->deleteCode($dto->phone_number);
            }
        });

        return $this->json([]);
    }

    /**
     * @return JsonResponse
     */
    public function find(int $chatId): JsonResponse
    {
        $student = $this->studentService->findByChatId($chatId);

        return $this->json(compact('student'));
    }
}
