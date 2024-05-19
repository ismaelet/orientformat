<?php

use LogicManager\TestLogic;

$legacyTest = test();

// setup variables
$questions = test_config($legacyTest->id, 'questions');

bump($questions);

$count = count($questions);

\LogicManager\TestLogic::setParameterCount($count);
