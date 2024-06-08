<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\GetInstitutionRequest;
use App\Services\InstitutionService;
use Illuminate\Http\Request;

class InstitutionController extends ApiController
{
    /**
     * @param InstitutionService $institutionService
     */
    public function __construct(protected InstitutionService $institutionService)
    {
        //
    }

    /**
     * @param GetInstitutionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(GetInstitutionRequest $request)
    {
        $institutions = $this->institutionService->loadList(
            $request->page,
            $request->limit,
            ['column' => 'id', 'order' => 'asc'],
            filters: ['district_id' => $request->district_id]
        );

        return $this->json(compact('institutions'));
    }
}
