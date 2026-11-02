<?php

namespace App\Http\Controllers;

use App\Services\LegacyPageRenderer;
use Illuminate\Http\Response;

class StudentHomeController extends Controller
{
    public function index(LegacyPageRenderer $renderer): Response
    {
        return $renderer->render(page: 'home');
    }
}
