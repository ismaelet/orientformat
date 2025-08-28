<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;

class TestController extends Controller {

	/**
	 * * Action: Show
	 */
	function show(Test $test) {
		$page = $test->filePath();
		$template = $test->template;
		$title = $test->name;

		if ($test->template != 'blade') {
			return \App\Legacy\LegacyView::setPage($page)
				->setTemplate($template)
				->setTitle($title)
				->set('test', $test)
				->show();
		}

		return view($test->view(), [
			'test' => $test,
			'title' => $title,
			'student' => student()
		]);
	}
}
