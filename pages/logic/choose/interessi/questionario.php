<?php

use LogicManager\TestLogic;

$test = test();

// setup variables
$questions = test_config($test->id, 'questions');

bump($questions);

$count = count($questions);

TestLogic::setParameterCount($count);
