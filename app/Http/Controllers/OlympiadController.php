<?php

namespace App\Http\Controllers;

use App\DTOs\Olympiad\OlympiadDTO;
use App\DTOs\Olympiad\OlympiadValidatedDTO;
use App\Events\OlympiadSavedEvent;
use App\Http\Requests\DeleteOlympiadRequest;
use App\Services\OlympiadService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OlympiadController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param OlympiadService $service
     */
    public function __construct(protected OlympiadService $service)
    {
        //
    }

    /**
     * @param DeleteOlympiadRequest $request
     * @return JsonResponse
     */
    public function ajaxDelete(DeleteOlympiadRequest $request): JsonResponse
    {
        $this->service->delete($request->id);

        return response()->json([
            'message' => __('status.deleted')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxResendButton(Request $request): JsonResponse
    {
        $result = $this->service->resendButton($request->id);

        return response()->json([
            'message' => $result ? __('Success') : __('Failed to resend the button')
        ]);
    }

    /**
     * @param OlympiadValidatedDTO $dto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(OlympiadValidatedDTO $dto)
    {
        $dto = $this->service->save($dto);

        event(new OlympiadSavedEvent($dto));

        $this->success(__('status.saved'));

        return $this->redirect('admin.olympiad.list');
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showForm(int $id = null)
    {
        $entry = $this->service->find($id);

        $this->ensureEntityExists($id, $entry);

        $this->title(
            is_null($id) ? __('Adding an olympiad') : __('Editing an olympiad')
        );

        $this->view('dashboard.olympiads.edit');

        $entry = $entry ? (new OlympiadDTO())->transform($entry) : null;

        /*if (!is_null($entry) && $entry->actionsAllowed === false) {
            $this->error(__('You cannot edit the olympiad which has status other than "Created" or "Finished"'));

            return redirect()->route('admin.olympiad.list');
        }*/

        return $this->render(compact('entry'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('Olympiads'));

        $this->view('dashboard.olympiads.list');

        $statuses = $this->service->getStatuses();

        return $this->render(compact('statuses'));
    }
}
