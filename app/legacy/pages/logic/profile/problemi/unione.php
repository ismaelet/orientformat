<?php

$count = 9;

Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        return isset($_POST['skip-cbx']) ? 0 : 100;
    });
