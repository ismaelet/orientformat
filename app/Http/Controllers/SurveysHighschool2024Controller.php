<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SurveysHighschool2024Controller extends Controller {

	/**
	 * * Action: Index
	 */
	public function index(): View {
		return view('surveys.highschool2024.index');
	}
}
