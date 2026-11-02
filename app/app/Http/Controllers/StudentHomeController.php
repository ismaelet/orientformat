<?php

namespace App\Http\Controllers;

use App\Legacy\LegacyView;
use Illuminate\Http\Response;

class StudentHomeController extends Controller
{
    public function index(): Response
    {
        return LegacyView::setPage('home')
            ->show();
    }
}
