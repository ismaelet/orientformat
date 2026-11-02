<?php

use Legacy\LogicManager\TestLogic;

$count = 1;
$correctAnswer = $correctAnswer ?? 6;

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        $correctAnswer = legacy_view_data()['correctAnswer'] ?? null;

        if ($_POST['field'][0] == $correctAnswer) {
            return 100;
        }

        return 0;
    });
