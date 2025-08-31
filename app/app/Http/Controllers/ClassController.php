<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller {

	public function create() {
		return view('teacher.classes.create');
	}
}
