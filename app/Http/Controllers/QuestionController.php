<?php

namespace App\Http\Controllers;

use App\DTOs\Olympiad\QuestionDTO;
use App\DTOs\Olympiad\QuestionValidatedDTO;
use App\Http\Requests\DeleteQuestionRequest;
use App\Services\OlympiadService;
use App\Services\QuestionService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param DeleteQuestionRequest $request
     * @return JsonResponse
     */
    public function ajaxDelete(DeleteQuestionRequest $request): JsonResponse
    {
        $this->service->delete($request->id);

        return response()->json([
            'message' => __('status.deleted')
        ]);
    }

    /**
     * @param QuestionValidatedDTO $dto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(QuestionValidatedDTO $dto)
    {
        $this->service->save($dto);

        $this->success(__('status.saved'));

        return redirect()->route('admin.olympiad.question.list', $dto->olympiad_id);
    }

    /**
     * @param int      $olympiadId
     * @param int|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $olympiadId, int $id = null)
    {
        $entry = $this->service->find($id);

        $this->ensureEntityExists($id, $entry);

        $this->title(is_null($id) ? __('Adding a question') : __('Editing a question'));

        $this->view('dashboard.olympiads.questions.edit');

        if (!is_null($entry)) {
            $entry = $entry ? (new QuestionDTO())->transform($entry) : null;
        }

        $types = $this->service->getTypes();

        return $this->render(compact('entry', 'olympiadId', 'types'));
    }

    /**
     * @param int $olympiadId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList(int $olympiadId)
    {
        $olympiad = $this->olympiadService->find($olympiadId);

        $this->title(__("Questions for \":olympiad\" olympiad", ['olympiad' => $olympiad->title]));

        $this->view('dashboard.olympiads.questions.list');

        return $this->render(compact('olympiad'));
    }
}
