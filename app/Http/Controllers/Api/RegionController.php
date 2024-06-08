<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\GetRegionsRequest;
use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends ApiController
{
    /**
     * @param RegionService $regionService
     */
    public function __construct(protected RegionService $regionService)
    {
        //
    }

    /**
     * @param GetRegionsRequest $request
     * @return JsonResponse
     */
    public function get(GetRegionsRequest $request): JsonResponse
    {
        $regions = $this->regionService->loadList($request->page, $request->limit, ['column' => 'id', 'order' => 'asc']);

        return $this->json(compact('regions'));
    }
}
