<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class HomeController extends Controller {

	/**
	 * Redirects to the appropriate dashboard based on user role
	 */
	public function index(): RedirectResponse {
		if (is_admin()) {
			return redirect('/admin');
		}

		if (is_teacher()) {
			return redirect()->route('teacher.dashboard');
		}

		return redirect()->route('student');
	}
}
