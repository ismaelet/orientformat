<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;
use Illuminate\Http\Request;

class TestController extends Controller {

	/**
	 * * Action: Show
	 */
	function show(Test $test) {
		$page = $test->filePath();
		$template = $test->template;
		$title = $test->title;

		\App\Legacy\LegacyView::setPage($page)
			->setTemplate($template)
			->setTitle($title)
			->set('test', $test)
			->show();
	}
}
