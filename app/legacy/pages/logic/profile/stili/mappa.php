<?php

$student = legacy_watched_student();
$test = legacy_test()->newTest();
$title = $title ?? __('Cognitive styles');
$helperClass = $test->helperClass();
$categories = $helperClass::getCategories();
$resultOrder = $resultOrder ?? ['Visivo', 'Globale', 'Collaborativo', 'Sistematico', 'Uditivo', 'Analitico', 'Autonomo', 'Intuitivo'];

$results = $helperClass::results(test: $test, student: $student);

if ($results) {
	$sortedResults = [];

	foreach ($resultOrder as $resultTag) {
		$result = $results->firstWhere('name', $resultTag);
		$category = $categories->where('name', $resultTag)->first();

		$sortedResults[] = [
			'name' => $result['name'],
			'translated_name' => $result['translated_name'],
			'info' => $category['info'],
			'value' => $result['value'],
			'percentage' => $result['percentage'],

			'tier' => match (true) {
				$result['percentage'] >= 75 => 4,
				$result['percentage'] >= 50 => 3,
				$result['percentage'] >= 25 => 2,
				default => 1,
			},
		];
	}
}
