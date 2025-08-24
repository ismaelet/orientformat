<?php

namespace App\Helpers;

use App\Models\Results\User\TestResult;

class TestResultHelper {

	public static function getResult(int $studentId, int $testId): ?string {
		return match ($testId) {
			// Ruota delle emozioni
			116 => self::getResultRuota($studentId, $testId),

			// Default
			default => null,
		};
	}

	public static function getResultRuota(int $studentId, int $testId): ?string {
		$testIds = [102, 115, 116];
		$results = [];

		$result1 = TestResult::where('studentId', $studentId)
			->where('testId', $testIds[0])
			->where('completed', true)
			->orderBy('created_at', 'desc')
			->first();

		$result2 = TestResult::where('studentId', $studentId)
			->where('testId', $testIds[1])
			->where('completed', true)
			->orderBy('created_at', 'desc')
			->first();

		$result3 = TestResult::where('studentId', $studentId)
			->where('testId', $testIds[2])
			->where('completed', true)
			->orderBy('created_at', 'desc')
			->first();

		collect([$result1, $result2, $result3])->filter()->each(function ($result) use (&$results) {
			$resultString = explode(',', $result->result)[0];

			if ($resultString) {
				$results[] = ucfirst(__($resultString));
			}
		});

		return implode(', ', $results);
	}
}
