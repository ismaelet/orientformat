<?php

use LogicManager\TestLogic;

$characters = test_config(testId(), 'characters');

bump($characters);

$selectedCharacterId = legacy_test()->completed ? legacy_test()->rawResults[0] : null;

\Legacy\LogicManager\TestLogic::setParameterCount(1);
