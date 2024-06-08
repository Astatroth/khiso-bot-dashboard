<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTranslationRequest;
use App\Services\TranslationManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationManagerController extends Controller
{
    /**
     * TranslationManagerController constructor.
     *
     * @param TranslationManagerService $service
     */
    public function __construct(protected TranslationManagerService $service)
    {
        //
    }

    /**
     *
     */
    public function ajaxDiscoverTranslations(): JsonResponse
    {
        $count = $this->service->discoverTranslations();

        return response()->json([
            'status' => 0,
            'count' => $count
        ]);
    }

    /**
     *
     */
    public function ajaxImportTranslations(Request $request): JsonResponse
    {
        $count = $this->service->importTranslations($request->replace);

        return response()->json([
            'status' => 0,
            'count' => $count
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxLoadTranslations(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'translations' => $this->service->getTranslations($request->group, $request->search)
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function ajaxLoadGroups(): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'groups' => $this->service->getGroups()
        ]);
    }

    /**
     * @param SaveTranslationRequest $request
     * @return JsonResponse
     */
    public function ajaxSaveTranslation(SaveTranslationRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'result' => $this->service->saveTranslation(
                $request->key, $request->language, $request->value, $request->group
            )
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxPublishTranslations(Request $request): JsonResponse
    {
        $this->service->exportTranslations($request->group, $request->group === '_json');

        return response()->json([
            'status' => 0
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showTranslationManager()
    {
        $this->title(__('Translation manager'));

        $this->view('dashboard.translation-manager.index');

        return $this->render();
    }
}
