<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;
use Illuminate\Http\RedirectResponse;

class TestController extends Controller {

	/**
	 * Display the specified resource
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

	/**
	 * Reset the specified resource
	 */
	function reset(Test $test): RedirectResponse {
		$student = student();

		$testResult = $student->testResult($test);

		if ($testResult) {
			$testResult->delete();
		}

		return redirect()->to($test->url());
	}

	/**
	 * Reset all the dependent tests
	 */
	function resetDependent(Test $test): RedirectResponse {
		$student = student();
		$dependentTests = $test->dependent_tests()?->sortBy('step');

		// Delete dependent test results
		$dependentTests->each(function (Test $dependentTest) use ($student) {
			$testResult = $student->testResult($dependentTest);

			if ($testResult) {
				$testResult->delete();
			}
		});

		// Delete main test result
		$testResult = $student->testResult($test);

		if ($testResult) {
			$testResult->delete();
		}

		$firstDependentTest = $dependentTests->first();

		return redirect()->to($firstDependentTest?->url());
	}
}
