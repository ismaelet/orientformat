<?php

use LogicManager\TestLogic;

$text = [
	[1 => 0],
	[1 => 'argomento'],
	[1 => 0],
	[1 => 'dove'],
	[1 => 0],
	[1 => 'causa'],
	[1 => 0],
	[1 => 'scopo'],
	[1 => 0],
	[1 => 'causa'],
	[1 => 0],
	[1 => 'causa'],
	[1 => 0],
	[1 => 'argomento'],
];

for ($i = 0; $i < count($text); $i++) {
	$text[$i][0] = __('tests.37-sentence-' . ($i + 1));
}

$results = test()->completed ? test()->rawResults : null;

$count = 7;

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function () {
			if (isset($_POST['skip-cbx'])) {
				return 0;
			} else {
				return 100;
			}
		}
	);
