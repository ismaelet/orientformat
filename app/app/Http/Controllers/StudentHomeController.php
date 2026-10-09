<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class StudentHomeController extends Controller {

    public function index(): Response {
        return \App\Legacy\LegacyView::setPage('home')
            ->show();
    }
}
