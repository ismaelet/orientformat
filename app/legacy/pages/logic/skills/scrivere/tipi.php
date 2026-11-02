<?php

use Legacy\LogicManager\TestLogic;

$types = [
    __('tests.62-question-1'),
    __('tests.62-question-2'),
    __('tests.62-question-3'),
    __('tests.62-question-4'),
    __('tests.62-question-5'),
    __('tests.62-question-6'),
    __('tests.62-question-7'),
    __('tests.62-question-8'),
    __('tests.62-question-9'),
    __('tests.62-question-10'),
    __('tests.62-question-11'),
    __('tests.62-question-12'),
    __('tests.62-question-13'),
    __('tests.62-question-14'),
    __('tests.62-question-15'),
    __('tests.62-question-16'),
];

$count = count($types);

TestLogic::setParameterCount($count);
