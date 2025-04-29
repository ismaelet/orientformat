<?php

use LogicManager\TestLogic;

$legacyTest = test();

// setup variables
$questions = [];

for ($i = 1; $i <= 114; $i++) {
	$questions[] = __('tests.91-question-' . $i);
}

bump($questions);

$count = count($questions);

\LogicManager\TestLogic::setParameterCount($count);
