<?php

namespace App\Http\Controllers\SchoolClass;

use App\Helpers\SectionResultHelper;
use App\Http\Controllers\Controller;
use App\Models\Activities\Area;
use App\Models\Activities\Section;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use Illuminate\Http\Request;
use Legacy\Activity\Result\Handler\StudentSectionResult;
use Legacy\UserSystem\Student as LegacyStudent;

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
		$legacyStudent = new LegacyStudent($student->id);
		$profile = $legacyStudent->profile;
		$beginnerChoice = $profile->dynamicChoice([1, 2, 4, 5]);
		$endChoice = $profile->dynamicChoice([3, 6]);

		$results = [
			'ascoltare' => SectionResultHelper::getResult($student, Section::find(11)),
			'parlare' => SectionResultHelper::getResult($student, Section::find(12)),
			'leggere' => SectionResultHelper::getResult($student, Section::find(39)),
			'scrivere' => SectionResultHelper::getResult($student, Section::find(14)),
			'attenzione' => SectionResultHelper::getResult($student, Section::find(9)),
			'ricordare' => SectionResultHelper::getResult($student, Section::find(10)),
			'problemi' => SectionResultHelper::getResult($student, Section::find(5)),
			'imparare' => SectionResultHelper::getResult($student, Section::find(40)),
			'creatività' => (new StudentSectionResult(17, $student->id))->detailedResult,
			'motivazione' => (new StudentSectionResult(7, $student->id))->result,
			'interessi' => (new StudentSectionResult(24, $student->id))->result,
		];

		// $results = [
		// 	'ascoltare' => SectionResultHelper::getResult($student, Section::find(11)),
		// 	'parlare' => SectionResultHelper::getResult($student, Section::find(12)),
		// 	'leggere' => SectionResultHelper::getResult($student, Section::find(39)),
		// 	'scrivere' => SectionResultHelper::getResult($student, Section::find(14)),
		// 	'attenzione' => SectionResultHelper::getResult($student, Section::find(9)),
		// 	'ricordare' => SectionResultHelper::getResult($student, Section::find(10)),
		// 	'problemi' => SectionResultHelper::getResult($student, Section::find(5)),
		// 	'imparare' => SectionResultHelper::getResult($student, Section::find(40)),
		// 	'creatività' => SectionResultHelper::getResult($student, Section::find(17)),
		// 	'motivazione' => SectionResultHelper::getResult($student, Section::find(7)),
		// 	'interessi' => SectionResultHelper::getResult($student, Section::find(24)),
		// ];


		// fetch advices
		$advices = [];
		$advicesRes = \App\Legacy\LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

		while ($advice = $advicesRes->fetch_assoc()) {
			$advices[$advice['id']] = $advice['advice'];
		}

		return view('class.students.poi.show', [
			'class' => $class,
			'student' => $student,
			'beginnerChoice' => $beginnerChoice,
			'endChoice' => $endChoice,
			'results' => $results,
			'advices' => $advices
		]);
	}
}
