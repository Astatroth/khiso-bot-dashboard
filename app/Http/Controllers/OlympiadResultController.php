<?php

namespace App\Http\Controllers;

use App\DTOs\Olympiad\OlympiadResultDTO;
use App\DTOs\Olympiad\ResultDTO;
use App\Services\OlympiadResultService;
use App\Services\OlympiadService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OlympiadResultController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param OlympiadResultService $service
     */
    public function __construct(protected OlympiadResultService $service)
    {
        //
    }

    public function export(int $olympiadId)
    {
        $result = $this->service->export($olympiadId);
        $olympiad = (new OlympiadService())->find($olympiadId);

        if ($result === false) {
            $this->error(__('Export failed.'));

            return redirect()->back();
        }

        return $result->download(
            'results_olympiad_'.$olympiadId.'_'.($olympiad->ends_at->format('d.m.Y')).'.xlsx',
            \Maatwebsite\Excel\Excel::XLSX,
            [
                'Content-Type' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        );
    }

    /**
     * @param int $olympiadId
     * @param int $resultId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForm(int $olympiadId, int $resultId)
    {
        $result = $this->service->find($resultId);

        $this->ensureEntityExists($resultId, $result);

        $this->title(__('Information on the result'));

        $this->view('dashboard.olympiads.results.view');

        $entry = (new ResultDTO())->transform($result);

        return $this->render(compact('entry', 'olympiadId'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList(int $olympiadId)
    {
        $this->title(__('Results'));

        $this->view('dashboard.olympiads.results.list');

        return $this->render(compact('olympiadId'));
    }
}
