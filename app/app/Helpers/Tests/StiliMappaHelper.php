<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class StiliMappaHelper {

	public static function results(Test $test, Student $student, array $categories): ?Collection {
		$resultRecord = TestResult::where('testId', $test->required_test->id)
			->where('studentId', $student->id)
			->first();

		if (!$resultRecord) {
			return null;
		}

		$rawResults = explode(',', $resultRecord->result);

		foreach ($categories as $categoryId => $category) {
			$results[$categoryId] = [];
			$results[$categoryId]['name'] = $category['name'];
			$results[$categoryId]['translated_name'] = $category['translated_name'];
			$results[$categoryId]['value'] = 0;
			$results[$categoryId]['max'] = 9;

			foreach ($category['questionIds'] as $questionId) {
				$results[$categoryId]['value'] += $rawResults[$questionId];
			}
		}

		foreach ($results as &$result) {
			$result['percentage'] = round($result['value'] / $result['max'] * 100);

			$result = collect($result);
		}

		return collect(array_values($results));
	}
}
