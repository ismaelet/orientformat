<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;

class SettingsController extends Controller {

	/**
	 * Show the student list
	 */
	public function studentIndex(Request $request, SchoolClass $class) {
		$students = $class->students->load('user')->sortBy('inverted_full_name');

		return view('class.settings.students.index', [
			'class' => $class,
			'students' => $students
		]);
	}
}
