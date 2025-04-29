<?php

use LogicManager\TestLogic;

$colors = ['c4', 'c1', 'c5', 'c2'];

$questions = [];
$answers = [];

for ($i = 1; $i <= 8; $i++) {
	$questions[] = __('tests.47-question-' . $i);

	for ($j = 1; $j <= 8; $j++) {
		$answers[$j - 1][] = __('tests.47-answer-' . $i . '-' . $j);
	}
}

$count = count($questions);

\LogicManager\TestLogic::setParameterCount($count);

bump($questions);
bump($answers);
