<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class TemperamentoRiepilogoHelper {

	public static function results(Test $test, Student $student): ?Collection {
		$results = [];
		$dependentTests = $test->dependent_tests();

		foreach ($dependentTests as $dependentTest) {
			$testResult = $student->testResult($dependentTest);

			if ($testResult && $testResult->completed()) {
				$results[] = collect([
					'name' => self::getSections()[$dependentTest->step] ?? $dependentTest->name,
					'value' => round($testResult->percentage / 100 * 6),
					'percentage' => $testResult->percentage
				]);
			}
		}

		return empty($results) ? null : collect($results);
	}

	/**
	 * Get the names of the sections of the test
	 */
	private static function getSections(): array {
		return [
			1 => __('tests.46-section-1'),
			2 => __('tests.46-section-2'),
			3 => __('tests.46-section-3'),
			4 => __('tests.46-section-4'),
			5 => __('tests.46-section-5'),
		];
	}
}
