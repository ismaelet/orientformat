<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LegacyController extends Controller {
    public function __invoke() {
        ob_start();

        require app_path('Http') . '/legacy.php';

        $output = ob_get_clean();

        return $output;
    }
}
