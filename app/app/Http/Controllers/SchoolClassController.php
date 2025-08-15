<?php

namespace App\Http\Controllers;

use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller {

	/**
	 * Show the class dashboard
	 */
	public function show(SchoolClass $class) {
		return view('class.show', [
			'class' => $class,
		]);
	}

	/**
	 * Show the list of students for the results
	 */
	public function studentResultsIndex(SchoolClass $class) {
		$class->load('students', 'students.user');

		return view('class.students.results.index', [
			'class' => $class,
		]);
	}
}
