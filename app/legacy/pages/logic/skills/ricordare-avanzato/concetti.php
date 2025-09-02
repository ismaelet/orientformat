<?php

define('_CONCEPTS', [
	__('tests.55-concept-1'),
	__('tests.55-concept-2'),
	__('tests.55-concept-3'),
	__('tests.55-concept-4'),
	__('tests.55-concept-5'),
	__('tests.55-concept-6'),
	__('tests.55-concept-7'),
	__('tests.55-concept-8'),
	__('tests.55-concept-9'),
	__('tests.55-concept-10'),
	__('tests.55-concept-11'),
	__('tests.55-concept-12'),
	__('tests.55-concept-13'),
]);

use LogicManager\TestLogic;

$legacyTest = test();

$time_str = '';

$count = count(_CONCEPTS);

// fetch previous results
$results = \App\Legacy\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $legacyTest->id]);

if ($results) {
	$results = explode(',', $results);
}

$time = !empty($legacyTest->rawResults[0]) ? $legacyTest->rawResults[0] : 0;

$minutes = floor($time / 60);
$seconds = $time - $minutes * 60;

if ($minutes) {
	$time_str .= $minutes == 1 ? '1 minuto e ' : $minutes . ' minuti e ';
}

$time_str .= $seconds == 1 ? '1 secondo' : $seconds . ' secondi';

// process result
\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$rightN = 0;
			$legacyTest = test();
			$concepts = _CONCEPTS;
			$results = $_POST['field_other'];

			foreach ($results as &$value) {
				$value = str_replace(',', '', trim($value));
				$found = array_search(strtolower($value), $concepts);

				if ($found !== false) {
					$rightN++;
					$concepts[$found] = '-';
				}
			}

			$results = implode(',', $results);

			\App\Legacy\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id]);
			\App\Legacy\LegacyDB::add('results_others (userID, testID, result) VALUES (?, ?, ?)', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id, $results]);

			return round($rightN / $count * 100);
		}
	);
