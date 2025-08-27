<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use Illuminate\Http\Request;

class StudentResultController extends Controller {

	/**
	 * Show the results for a specific student
	 */
	public function show(Request $request, SchoolClass $class, Student $student) {
		// Review results
		$reviewResults = ReviewResult::where('studentId', $student->id)
			->with('review')
			->orderByDesc('id')
			->get();

		// Grades
		$grades = Grade::where('is_professional', $class->isProfessional())
			->where('absolute_number', '>=', $class->isMiddleSchool() ? 1 : 4)
			->where('absolute_number', '<=', $class->grade()->absolute_number)
			->orderByDesc('absolute_number')
			->with('sections', 'sections.area')
			->get();

		return view('class.students.results.show', [
			'class' => $class,
			'student' => $student,
			'reviewResults' => $reviewResults,
			'grades' => $grades
		]);
	}

	/**
	 * Show the P.O.I. for a specific student
	 */
	public function showPoi(Request $request, SchoolClass $class, Student $student) {
		return view('class.students.poi.show', [
			'class' => $class,
			'student' => $student,
		]);
	}
}
