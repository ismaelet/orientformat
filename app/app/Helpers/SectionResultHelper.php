<?php

namespace App\Helpers;

use App\Models\Activities\Section;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use Legacy\Activity\Result\Handler\StudentSectionResult;

class SectionResultHelper {

	public static function getResult(Student $student, Section $section): ?string {
		return match ($section->id) {
			// Simple one-test results
			5, 9, 30 => self::sectionSelfEvaluationResult($student, $section),

			// Result of agglomerates of tests
			3, 4, 10, 11, 12, 14, 17, 29, 31, 32, 33, 39, 40  => self::sectionAgglomeratedResult($student, $section),

			// Default
			default => (new StudentSectionResult($section->id, $student->id))->result,
		};
	}

	/**
	 * Get the result of the self-evaluation test for a specific section.
	 */
	public static function sectionSelfEvaluationResult(Student $student, Section $section): ?string {
		$selfEvaluationTest = $section->evaluation_test;

		$selfEvaluationResult = TestResult::where('studentId', $student->id)
			->where('testId', $selfEvaluationTest->id)
			->where('completed', true)
			->orderBy('created_at', 'desc')
			->first();

		if (!$selfEvaluationResult) {
			return null;
		}

		return $selfEvaluationResult->percentage . '%';
	}

	/**
	 * Get the result of the agglomerated tests for a specific section.
	 */
	public static function sectionAgglomeratedResult(Student $student, Section $section): ?string {
		$selfEvaluationTest = $section->evaluation_test;

		$requiredTestIds = $selfEvaluationTest->dependent_tests()->pluck('id');

		$relatedResults = TestResult::where('studentId', $student->id)
			->whereIn('testId', $requiredTestIds)
			->where('completed', true)
			->orderBy('created_at', 'desc')
			->get();

		$avgPercentage = round($relatedResults->avg('percentage'));

		return $avgPercentage ? $avgPercentage . '%' : null;
	}
}
