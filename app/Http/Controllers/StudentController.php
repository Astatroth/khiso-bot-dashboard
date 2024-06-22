<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use App\Traits\DynamicTableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use DynamicTableTrait;

    /**
     * @param StudentService $service
     */
    public function __construct(protected StudentService $service)
    {
        //
    }

    /**
     * @param int $olympiadId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export()
    {
        $result = $this->service->export();

        if ($result === false) {
            $this->error(__('Export failed.'));

            return redirect()->back();
        }

        return $result->download(
            'students_'.date('d.m.Y').'.xlsx',
            \Maatwebsite\Excel\Excel::XLSX,
            [
                'Content-Type' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('Users'));

        $this->view('dashboard.students.list');

        return $this->render();
    }
}
