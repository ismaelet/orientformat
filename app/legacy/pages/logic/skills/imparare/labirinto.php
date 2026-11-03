<?php

use Legacy\LogicManager\TestLogic;

// questions

$questions = [
    [[__('tests.36-step-1-1'), __('tests.36-step-1-2'), __('tests.36-step-1-3')], 1],
    [[__('tests.36-step-2-1'), __('tests.36-step-2-2'), __('tests.36-step-2-3')], 2],
    [[__('tests.36-step-3-1'), __('tests.36-step-3-2'), __('tests.36-step-3-3')], 3],
    [[__('tests.36-step-4-1'), __('tests.36-step-4-2'), __('tests.36-step-4-3')], 2],
    [[__('tests.36-step-5-1'), __('tests.36-step-5-2'), __('tests.36-step-5-3')], 3],
    [[__('tests.36-step-6-1'), __('tests.36-step-6-2'), __('tests.36-step-6-3')], 1],
];

$titles = [
    ['A', 'c4'],
    ['B', 'c5'],
    ['C', 'c2'],
];

$count = count($questions);

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        if (isset($_POST['skip-cbx'])) {
            return 0;
        } else {
            return 100;
        }
    });
