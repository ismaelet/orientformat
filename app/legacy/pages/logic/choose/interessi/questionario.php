<?php

use LogicManager\TestLogic;

$legacyTest = legacy_test();

// setup variables
$questions = [];

for ($i = 1; $i <= count(test_config(legacy_test()->id, 'questions')); $i++) {
	$questions[] = __('tests.' . legacy_test()->id . '-question-' . $i);
}

bump($questions);

$count = count($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count);
