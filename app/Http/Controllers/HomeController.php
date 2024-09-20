<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class HomeController extends Controller {

	/**
	 * * Action: Index
	 */
	public function index(): RedirectResponse {
		if (is_admin()) {
			return redirect()->route('admin.dashboard');
		}

		if (is_teacher()) {
			return redirect()->route('teacher.dashboard');
		}

		return redirect()->route('student');
	}
}
