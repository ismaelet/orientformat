<?php

use LogicManager\TestLogic;

$count = 0;
$parameterCount = [];
$results = test()->completed ? test()->rawResults : null;

$text = [
	[__('tests.132-sentence-1'), 'chi'],
	[__('tests.132-sentence-2')],
	[__('tests.132-sentence-3'), 'chi'],
	[__('tests.132-sentence-4')],
	[__('tests.132-sentence-5'), 'come'],
	[__('tests.132-sentence-6'), 'come'],
	[__('tests.132-sentence-7')],
	[__('tests.132-sentence-8')],
	[__('tests.132-sentence-9'), 'quando'],
	[__('tests.132-sentence-10')],
	[__('tests.132-sentence-11'), 'quando'],
	[__('tests.132-sentence-12')],
	[__('tests.132-sentence-13'), 'scopo'],
	[__('tests.132-sentence-14')],
	[__('tests.132-sentence-15'), 'scopo'],
	[__('tests.132-sentence-16')],
	[__('tests.132-sentence-17'), 'scopo'],
	[__('tests.132-sentence-18')],
	[__('tests.132-sentence-19'), 'quando'],
	[__('tests.132-sentence-20')],
	[__('tests.132-sentence-21'), 'scopo'],
	[__('tests.132-sentence-22')],
	[__('tests.132-sentence-23'), 'quando'],
	[__('tests.132-sentence-24')],
	[__('tests.132-sentence-25'), 'come'],
	[__('tests.132-sentence-26')],
	[__('tests.132-sentence-27'), 'scopo'],
	[__('tests.132-sentence-28')],
	[__('tests.132-sentence-29'), 'causa'],
	[__('tests.132-sentence-30')],
	[__('tests.132-sentence-31'), 'conseguenza'],
	[__('tests.132-sentence-32')],
	[__('tests.132-sentence-33'), 'causa'],
	[__('tests.132-sentence-34')],
	[__('tests.132-sentence-35'), 'conseguenza'],
	[__('tests.132-sentence-36')]
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

\LogicManager\TestLogic::setParameterCount($count)
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
