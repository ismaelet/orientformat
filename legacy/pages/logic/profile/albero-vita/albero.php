<?php

use LogicManager\TestLogic;

$characters = test_config(testId(), 'characters');

bump($characters);

$selectedCharacterId = test()->completed ? test()->rawResults[0] : null;

Test\Legacy\System\Classes\Logic::setParameterCount(1);
