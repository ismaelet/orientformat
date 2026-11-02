<?php

use Legacy\LogicManager\TestLogic;

$legacyTest = legacy_test();

$boxes = [
    ['autofilled' => 1],
    ['autofilled' => 1],
    ['autofilled' => 0],
    ['autofilled' => 0],
    ['autofilled' => 0],
    ['autofilled' => 1],
    ['autofilled' => 0],
    ['autofilled' => 0],
    ['autofilled' => 0],
    ['autofilled' => 0],
    ['autofilled' => 1],
];

foreach ($boxes as $key => &$box) {
    $box['content'] = __('tests.38-box-'.($key + 1));
}

bump($boxes);

$i = 0;
foreach ($boxes as $key => &$box) {
    if (! $box['autofilled']) {
        $i++;
    }

    if ($legacyTest->completed) {
        $box['classes'] = $box['autofilled'] || $legacyTest->rawResults[$i - 1] == $key ? 'right' : 'wrong';
        $box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[$legacyTest->rawResults[$i - 1]]['content'] ?? false);
    } else {
        $box['classes'] = $box['autofilled'] ? 'active' : 'droppable';
        $box['text'] = $box['autofilled'] ? $box['content'] : '';
    }
}

$count = $i;

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function ($count) {
        $boxes = legacy_view_data()['boxes'] ?? null;

        $rightN = 0;

        $i = 0;
        foreach ($boxes as $key => $box) {
            if (! $box['autofilled']) {

                $i++;

                if ($_POST['field'][$i - 1] == $key) {
                    $rightN++;
                }
            }
        }

        return round($rightN / $count * 100);
    });
