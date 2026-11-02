<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard
     */
    public function index(): View
    {
        return view('administrator.dashboard', []);
    }
}
