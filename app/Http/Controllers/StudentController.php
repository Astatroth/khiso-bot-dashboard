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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showList()
    {
        $this->title(__('Users'));

        $this->view('dashboard.students.list');

        return $this->render();
    }
}
