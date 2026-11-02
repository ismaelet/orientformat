<?php

use Legacy\LogicManager\TestLogic;

$test = legacy_test()->newTest();
$characters = $test->helper()->getCharacters();

bump($characters);

$selectedCharacterId = legacy_test()->completed ? legacy_test()->rawResults[0] : null;

TestLogic::setParameterCount(1);
