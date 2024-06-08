<?php

namespace App\Http\Controllers;

use App\DTOs\SeoValidatedDTO;
use App\Http\Requests\Seo\DeleteSeoRequest;
use App\Services\SeoService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    use DynamicTableTrait;

    /**
     * SeoController constructor.
     *
     * @param SeoService $service
     */
    public function __construct(protected SeoService $service)
    {
        //
    }

    /**
     * @param DeleteSeoRequest $request
     */
    public function ajaxDelete(DeleteSeoRequest $request): void
    {
        $this->service->delete($request->id);
    }

    /**
     * @param SeoValidatedDTO $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function save(SeoValidatedDTO $dto)
    {
        $this->service->save($dto);

        $this->success(__('status.saved'));

        return $this->redirect('admin.seo.list');
    }

    /**
     * @param int|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $id = null)
    {
        $entry = $this->service->getEntry($id);

        $this->title(is_null($entry) ? __('Adding an entry') : __('Editing an entry'));

        $this->view('dashboard.seo.edit');

        return $this->render(compact('entry'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('SEO'));

        $this->view('dashboard.seo.list');

        return $this->render();
    }
}
