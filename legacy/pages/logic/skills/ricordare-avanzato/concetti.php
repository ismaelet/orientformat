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

$legacyTest = test();

$time_str = '';

$count = count(_CONCEPTS);

// fetch previous results
$results = \Legacy\System\Classes\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $legacyTest->id]);

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
\LogicManager\TestLogic::setParameterCount($count)
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

			\Legacy\System\Classes\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id]);
			\Legacy\System\Classes\LegacyDB::add('results_others (userID, testID, result) VALUES (?, ?, ?)', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id, $results]);

			return round($rightN / $count * 100);
		}
	);
