<?php

namespace App\Http\Controllers;

use App\DTOs\Olympiad\QuestionDTO;
use App\DTOs\Olympiad\QuestionValidatedDTO;
use App\Http\Requests\DeleteQuestionRequest;
use App\Models\Olympiad;
use App\Services\OlympiadService;
use App\Services\QuestionService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param QuestionService $service
     * @param OlympiadService $olympiadService
     */
    public function __construct(protected QuestionService $service, protected OlympiadService $olympiadService)
    {
        //
    }

    /**
     * @param QuestionValidatedDTO $dto
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function save(QuestionValidatedDTO $dto)
    {
        $olympiad = $this->olympiadService->find($dto->olympiad_id);
        if ($olympiad->status !== Olympiad::STATUS_CREATED) {
            throw ValidationException::withMessages([__('You cannot edit a question from an active olympiad.')]);
        }

        $this->service->save($dto);

        $this->success(__('status.saved'));

        return redirect()->route('admin.olympiad.list');
    }

    /**
     * @param int $olympiadId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $olympiadId)
    {
        $olympiad = $this->olympiadService->find($olympiadId);
        $entry = $olympiad->question;
        if (!is_null($entry)) {
            $entry = $entry ? (new QuestionDTO())->transform($entry) : null;
        }

        $this->title(__('":olympiad_name" olympiad question', ['olympiad_name' => $olympiad->title]));

        $this->view('dashboard.olympiads.question.edit');

        return $this->render(compact('entry', 'olympiad'));
    }
}
