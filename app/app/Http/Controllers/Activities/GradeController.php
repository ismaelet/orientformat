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
		$schoolClass = Auth::user()->student->school_class;
		$legacySchoolClass = new LegacySchoolClass($schoolClass->id);

		\App\Legacy\LegacyView::setPage('activities/grades')
			->set('schoolClass', $legacySchoolClass)
			->show();
	}

	/**
	 * * Action: Show
	 */
	function show(int $gradeNumber) {
		function realGradeId($oldGradeId) {
			switch (true) {
				case strpos($oldGradeId, 'P'):
					return $oldGradeId[0] + 3;

				case strpos($oldGradeId, 'L'):
					return $oldGradeId[0];

				default:
					return $oldGradeId;
			}
		}

		$student = Auth::user()->student;
		$schoolClass = $student->school_class;
		$professional = $schoolClass->professional;

		if (!$schoolClass->hasGrade($gradeNumber)) {
			return redirect()->route('activities.grades.index');
		}

		$grade = new Grade($gradeNumber, $professional);

		$legacyGradeNumber = $grade->number;
		$legacyGrade = new LegacyGrade($legacyGradeNumber);
		$legacyGradeModel = new LegacyGradeModel(realGradeId($legacyGradeNumber));

		session()->put('activities-year', $legacyGradeNumber);

		\App\Legacy\LegacyView::setPage('activities/list')
			->set('student', $student)
			->set('grade', $grade)
			->set('legacyGrade', $legacyGrade)
			->set('legacyGradeModel', $legacyGradeModel)
			->show();
	}
}
