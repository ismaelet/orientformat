<?php

use Legacy\LogicManager\TestLogic;

define('_RIGHT_COUNT', 5);

$legacyTestCount = 1;

TestLogic::setParameterCount($legacyTestCount)
    ->setTestSubmitFunction(function () {
        $right = _RIGHT_COUNT;

        return $_POST['field'][0] == $right ? 100 : 0;
    });
