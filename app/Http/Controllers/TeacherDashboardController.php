<?php

namespace App\Http\Controllers;

class TeacherDashboardController extends Controller {

	/**
	 * * Action: Index
	 */
	public function index() {
		\App\Legacy\LegacyView::setPage('teacher/home')
			->show();
	}
}
