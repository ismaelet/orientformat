<?php

$test = legacy_test()->newTest();
$characters = $test->helper()->getCharacters();

bump($characters);

$selectedCharacterId = legacy_test()->completed ? legacy_test()->rawResults[0] : null;

\Legacy\LogicManager\TestLogic::setParameterCount(1);
