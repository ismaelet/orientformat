<?php

define('_CONCEPTS', [
	'popolazione',
	'flora',
	'insediamenti abitativi',
	'mondo inorganico',
	'idrologia',
	'insediamenti produttivi',
	'ambiente naturale',
	'mondo organico',
	'minerali',
	'fattori atmosferici',
	'fauna',
	'ambiente antropico',
	'trasporti',
]);

use LogicManager\TestLogic;

$test = test();

$time_str = '';

$count = count(_CONCEPTS);

// fetch previous results
$results = DB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $test->id]);

if ($results) {
	$results = explode(',', $results);
}

$time = !empty($test->rawResults[0]) ? $test->rawResults[0] : 0;

$minutes = floor($time / 60);
$seconds = $time - $minutes * 60;

if ($minutes) {
	$time_str .= $minutes == 1 ? '1 minuto e ' : $minutes . ' minuti e ';
}

$time_str .= $seconds == 1 ? '1 secondo' : $seconds . ' secondi';

// process result
TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$rightN = 0;
			$test = test();
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

			DB::delete('results_others WHERE userID = ? AND testID = ?', [studentId(), $test->id]);
			DB::add('results_others (userID, testID, result) VALUES (?, ?, ?)', [studentId(), $test->id, $results]);

			return round($rightN / $count * 100);
		}
	);
