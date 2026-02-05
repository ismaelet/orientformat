<?php

\App\Legacy\StyleLoader::add('profile/temperamento/temperamento', 'page');
\App\Legacy\ScriptLoader::add('profile/temperamento/temperamento', 'page');

$legacyTest = legacy_test();
$mainTestId = $mainTestId ?? $legacyTest->id;

$questions = [
    [__('tests.' . $mainTestId . '-answer-1-negative'), __('tests.' . $mainTestId . '-answer-1-positive')],
    [__('tests.' . $mainTestId . '-answer-2-negative'), __('tests.' . $mainTestId . '-answer-2-positive')],
    [__('tests.' . $mainTestId . '-answer-3-negative'), __('tests.' . $mainTestId . '-answer-3-positive')],
    [__('tests.' . $mainTestId . '-answer-4-negative'), __('tests.' . $mainTestId . '-answer-4-positive')],
];

$count = count($questions);

bump($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(
        function ($count) {
            $max = $count * 5;
            $score = 0;

            foreach ($_POST['field'] as $value) {
                $score += $value;
            }

            return round($score / $max * 100);
        }
    );
