<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        $stats = $this->dashboard->getStats();

        return view('dashboard.index', compact('stats'));
    }
}
