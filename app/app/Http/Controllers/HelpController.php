<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller {
	public function index() {
		ob_start();

		require app_path('Http') . '/legacy.php';

		$output = ob_get_clean();

		return $output;
	}
}
