<?php

namespace App\Http\Controllers;

use App\DTOs\Telegram\ChannelDTO;
use App\DTOs\Telegram\ChannelValidatedDTO;
use App\Http\Requests\Telegram\DeleteTelegramChannelRequest;
use App\Services\TelegramChannelService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramChannelController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param TelegramChannelService $service
     */
    public function __construct(protected TelegramChannelService $service)
    {
        //
    }

    /**
     * @param DeleteTelegramChannelRequest $request
     * @return JsonResponse
     */
    public function ajaxDelete(DeleteTelegramChannelRequest $request): JsonResponse
    {
        $this->service->delete($request->id);

        return response()->json([
            'message' => __('status.deleted')
        ]);
    }

    /**
     * @param ChannelValidatedDTO $dto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(ChannelValidatedDTO $dto)
    {
        $this->service->save($dto);

        $this->success(__('status.saved'));

        return $this->redirect('admin.channels.list');
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $id = null)
    {
        $entry = $this->service->find($id);

        $this->ensureEntityExists($id, $entry);

        $this->title(
            is_null($id) ? __('Adding a channel') : __('Editing a channel')
        );

        $this->view('dashboard.channels.edit');

        $entry = $entry ? (new ChannelDTO())->transform($entry) : null;

        return $this->render(compact('entry'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('Partner channels'));

        $this->view('dashboard.channels.list');

        return $this->render();
    }
}
