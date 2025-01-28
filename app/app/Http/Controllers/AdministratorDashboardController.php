<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdministratorDashboardController extends Controller {

	/**
	 * Display the administrator dashboard.
	 * 
	 * @return View
	 */
	public function index(): View {
		$administrator = auth()->user()->administrator;

		return view('administrator.dashboard', [
			'administrator' => $administrator,
			'school' => $administrator->school,
		]);
	}
}
