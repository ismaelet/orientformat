<?php

use LogicManager\TestLogic;

$legacyTest = test();

// setup variables
$questions = [];

for ($i = 1; $i <= count(test_config(test()->id, 'questions')); $i++) {
	$questions[] = __('tests.' . test()->id . '-question-' . $i);
}

bump($questions);

$count = count($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count);
