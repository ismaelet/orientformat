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
			'classLocation' => 'welcome'
		]);
	}
}
