<?php

use Legacy\LogicManager\TestLogic;

$count = 1;

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        return ((int) $_POST['field'][0]) * 10;
    });
