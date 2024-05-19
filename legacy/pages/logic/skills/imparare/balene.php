<?php

/*
use LogicManager\TestLogic;

$count = 0;
$parameterCount = [];
$results = test()->completed ? test()->rawResults : null;

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
*/