<?php

use LogicManager\TestLogic;

$characters = test_config(testId(), 'characters');

bump($characters);

$selectedCharacterId = test()->completed ? test()->rawResults[0] : null;

\LogicManager\TestLogic::setParameterCount(1);
