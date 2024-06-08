<?php

namespace App\Http\Controllers;

use App\Services\ShortcutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    /**
     * ShortcutController constructor.
     *
     * @param ShortcutService $service
     */
    public function __construct(protected ShortcutService $service)
    {
        //
    }

    /**
     * Remove a shortcut.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxRemove(Request $request): JsonResponse
    {
        $this->service->remove($request->id);

        return response()->json([
            'status' => 0
        ]);
    }

    /**
     * Add or remove a shortcut.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxToggle(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'state' => $this->service->toggleShortcut($request->shortcutName, $request->routeName, $request->routeParams)
        ]);
    }
}
