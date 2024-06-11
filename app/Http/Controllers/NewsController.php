<?php

namespace App\Http\Controllers;

use App\DTOs\News\NewsDTO;
use App\DTOs\News\NewsValidatedDTO;
use App\Events\NewsSavedEvent;
use App\Http\Requests\DeleteNewsRequest;
use App\Services\NewsService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param NewsService $service
     */
    public function __construct(protected NewsService $service)
    {
        //
    }

    /**
     * @param DeleteNewsRequest $request
     * @return JsonResponse
     */
    public function ajaxDelete(DeleteNewsRequest $request): JsonResponse
    {
        $this->service->delete($request->id);

        return response()->json([
            'message' => __('status.deleted')
        ]);
    }

    /**
     * @param NewsValidatedDTO $dto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(NewsValidatedDTO $dto)
    {
        $dto = $this->service->save($dto);

        event(new NewsSavedEvent($dto));

        $this->success(__('status.saved'));

        return $this->redirect('admin.news.list');
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $id = null)
    {
        $entry = $this->service->find($id);

        $this->ensureEntityExists($id, $entry);

        if (!$entry->actionsAllowed) {
            $this->error(__('You cannot edit the article which has status other than "Queued" or "Failed"'));
        }

        $this->title(
            is_null($id) ? __('Adding a post') : __('Editing a post')
        );

        $this->view('dashboard.news.edit');

        $entry = $entry ? (new NewsDTO())->transform($entry) : null;
        $typePhoto = $this->service->getType('photo');
        $typeVideo = $this->service->getType('video');

        return $this->render(compact('entry', 'typePhoto', 'typeVideo'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('News'));

        $this->view('dashboard.news.list');

        $statuses = $this->service->getStatuses();

        return $this->render(compact('statuses'));
    }
}
