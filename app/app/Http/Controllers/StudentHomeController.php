<?php

namespace App\Http\Controllers;

class StudentHomeController extends Controller {

	/**
	 * * Action: Index
	 */
	public function index() {
		$page = 'home';

		\App\Legacy\LegacyView::setPage($page)
			->show();
	}
}
