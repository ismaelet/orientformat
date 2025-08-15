<?php

use LogicManager\TestLogic;

$count = 0;
$parameterCount = [];
$results = test()->completed ? test()->rawResults : null;

$text = [
	'sentence-1' => [__('tests.132-sentence-1'), 'chi'],
	'sentence-2' => [__('tests.132-sentence-2'),],
	'sentence-3' => [__('tests.132-sentence-3'), 'chi'],
	'sentence-4' => [__('tests.132-sentence-4'),],
	'sentence-5' => [__('tests.132-sentence-5'), 'come'],
	'sentence-6' => [__('tests.132-sentence-6'), 'come'],
	'sentence-7' => [__('tests.132-sentence-7'),],
	'sentence-8' => [__('tests.132-sentence-8'),],
	'sentence-9' => [__('tests.132-sentence-9'), 'quando'],
	'sentence-10' => [__('tests.132-sentence-10'),],
	'sentence-11' => [__('tests.132-sentence-11'), 'quando'],
	'sentence-12' => [__('tests.132-sentence-12'),],
	'sentence-13' => [__('tests.132-sentence-13'), 'scopo'],
	'sentence-14' => [__('tests.132-sentence-14'),],
	'sentence-15' => [__('tests.132-sentence-15'), 'scopo'],
	'sentence-16' => [__('tests.132-sentence-16'),],
	'sentence-17' => [__('tests.132-sentence-17'), 'scopo'],
	'sentence-18' => [__('tests.132-sentence-18'),],
	'sentence-19' => [__('tests.132-sentence-19'),],
	'sentence-20' => [__('tests.132-sentence-20'), 'quando'],
	'sentence-21' => [__('tests.132-sentence-21'),],
	'sentence-22' => [__('tests.132-sentence-22'), 'scopo'],
	'sentence-23' => [__('tests.132-sentence-23'),],
	'sentence-24' => [__('tests.132-sentence-24'), 'quando'],
	'sentence-25' => [__('tests.132-sentence-25'),],
	'sentence-26' => [__('tests.132-sentence-26'), 'come'],
	'sentence-27' => [__('tests.132-sentence-27'),],
	'sentence-28' => [__('tests.132-sentence-28'), 'scopo'],
	'sentence-29' => [__('tests.132-sentence-29'),],
	'sentence-30' => [__('tests.132-sentence-30'),],
	'sentence-31' => [__('tests.132-sentence-31'), 'causa'],
	'sentence-32' => [__('tests.132-sentence-32'),],
	'sentence-33' => [__('tests.132-sentence-33'), 'conseguenza'],
	'sentence-34' => [__('tests.132-sentence-34'),],
	'sentence-35' => [__('tests.132-sentence-35'), 'causa'],
	'sentence-36' => [__('tests.132-sentence-36'),],
	'sentence-37' => [__('tests.132-sentence-37'), 'conseguenza'],
	'sentence-38' => [__('tests.132-sentence-38'),],
];

foreach ($text as $textPart) {
	if (isset($textPart[1])) {
		$textType = $textPart[1];

		$count++;

		if (!isset($parameterCount[$textType])) {
			$parameterCount[$textType] = 0;
		}

		$parameterCount[$textType]++;
	}
}

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$resultCount = 0;

			foreach ($_POST['field'] as $result) {
				if ($result) {
					$resultCount++;
				}
			}

			return round($resultCount / $count * 100);
		}
	);
