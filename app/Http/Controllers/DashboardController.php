<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDashboard()
    {
        $this->title(__('Dashboard'));

        $this->view('dashboard.index');

        return $this->render();
    }
}
