<?php

use App\Legacy\LegacyView;

$count = 1;
$correctAnswer = $correctAnswer ?? 6;

Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        $correctAnswer = LegacyView::get('correctAnswer');

        if ($_POST['field'][0] == $correctAnswer) {
            return 100;
        }

        return 0;
    });
