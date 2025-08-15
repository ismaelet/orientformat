<?php

$questions = [
	__('tests.16-field-1'),
	__('tests.16-field-2'),
	__('tests.16-field-3'),
	__('tests.16-field-4'),
	__('tests.16-field-5'),
	__('tests.16-field-6'),
];

$count = count($questions);

bump($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$max = 4 * $count;
		$score = 0;

		foreach ($_POST['field'] as $val) {
			$score += $val;
		}

		return round($score / $max * 100, 0);
	});
