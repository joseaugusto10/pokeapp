<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(DashboardService $dashboardService)
    {
        $data = $this->dashboardService->metricas();
        return view('dashboard', $data);
    }
}
