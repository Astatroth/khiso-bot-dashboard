<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function executeCommand(Request $request): JsonResponse
    {
        \Artisan::call($request->commandSignature);

        return response()->json([
            'status' => 0,
            'result' => \Artisan::output()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showInterface()
    {
        $this->title(__('Artisan console'));

        $this->view('dashboard.artisan.index');

        $commands = config('artisan.commands');

        return $this->render(compact('commands'));
    }
}
