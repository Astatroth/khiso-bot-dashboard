<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\GetDistrictsRequest;
use App\Services\DistrictService;
use Illuminate\Http\JsonResponse;

class DistrictController extends ApiController
{
    /**
     * @param DistrictService $districtService
     */
    public function __construct(protected DistrictService $districtService)
    {
        //
    }

    /**
     * @param GetDistrictsRequest $request
     * @return JsonResponse
     */
    public function get(GetDistrictsRequest $request): JsonResponse
    {
        $districts = $this->districtService->loadList(
            $request->page,
            $request->limit,
            ['column' => 'id', 'order' => 'asc'],
            filters: ['region_id' => $request->region_id]
        );

        return $this->json(compact('districts'));
    }
}
