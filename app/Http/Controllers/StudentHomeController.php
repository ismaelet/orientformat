<?php

namespace App\Http\Controllers;

class StudentHomeController extends Controller {

	/**
	 * * Action: Index
	 */
	public function index() {
		$page = 'home';
		$middlewares = ['beginner-review', 'required-email'];

		\App\Legacy\LegacyView::setPage($page)
			->setMiddlewares($middlewares)
			->show();
	}
}
