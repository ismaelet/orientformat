<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Schools\Grade;
use Illuminate\Support\Facades\Auth;
use Legacy\SchoolSystem\Grade as LegacyGrade;
use Legacy\SchoolSystem\SchoolClass as LegacySchoolClass;
use LegacyModels\Activities\Grade as LegacyGradeModel;

class GradeController extends Controller {

	/**
	 * * Action: Index
	 */
	function index() {
		$student = Auth::user()->student;
		$class = $student->school_class;

		$grades = Grade::where('is_professional', $class->isProfessional())
			->where('absolute_number', '>=', $class->first_grade)
			->where('absolute_number', '<=', $class->last_grade)
			->orderBy('absolute_number')
			->with('completable_sections')
			->get();

		\App\Legacy\LegacyView::setPage('activities/grades')
			->set('class', $class)
			->set('grades', $grades)
			->set('student', $student)
			->show();
	}

	/**
	 * * Action: Show
	 */
	function show(Grade $grade) {
		$grade->load('areas', 'areas.sections', 'sections.tests');
		$student = Auth::user()->student;

		session()->put('activities-year', $grade->absolute_number);

		\App\Legacy\LegacyView::setPage('activities/list')
			->set('student', $student)
			->set('grade', $grade)
			->show();
	}
}
