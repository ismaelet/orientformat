<?php

namespace App\Helpers;

use App\Models\Schools\SchoolClass;

class ClassHelper {
	/**
	 * Update a class to the new school year
	 */
	public static function updateToNewYear(SchoolClass $class): void {
		// If it's before September, the current year is last year
		$currentYear = now()->month < 9 ? now()->year - 1 : now()->year;
		$startingYear = $class->startingYear;
		$startingGrade = $class->startingGrade;
		$maxGrade = $class->last_grade;
		$currentGrade = $startingGrade + ($currentYear - $startingYear);

		if ($maxGrade < $currentGrade) {
			$ended = true;
			$currentGrade = $maxGrade;
			$year = $startingYear + ($maxGrade - $startingGrade);
		} else {
			$ended = false;
			$year = $currentYear;
		}

		$name = self::generateName($currentGrade, $class->letter);

		$class->update([
			'grade' => $currentGrade,
			'name' => $name,
			'ended' => $ended,
			'year' => $year
		]);

		if ($class->isHighSchool()) {
			$class->update([
				'letter' => $name
			]);
		}
	}

	/**
	 * Generate a class name based on the grade and letter
	 */
	public static function generateName(int $grade, string $letter): string {
		// Generate middle school class names
		if ($grade < 4) {
			if (!preg_match('/\d/', $letter)) {
				return $grade . $letter;
			}

			return preg_replace('/\d/', (string)$grade, $letter, 1);
		}

		// Generate high school class names
		if (!preg_match('/\d/', $letter)) {
			return ($grade - 3) . $letter;
		}

		return preg_replace('/\d/', (string)$grade - 3, $letter, 1);
	}
}
