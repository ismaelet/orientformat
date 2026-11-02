<?php

use App\Legacy\LegacyView;

$legacyTest = legacy_test();

// setup variables
$boxes = [
    false,
    ['content' => __('tests.69-box-1'), 'reader' => 0, 'autofilled' => 0],
    false,
    false,
    ['content' => __('tests.69-box-2'), 'reader' => 0, 'autofilled' => 1],
    false,
    ['content' => __('tests.69-box-3'), 'reader' => 1, 'autofilled' => 0],
    ['content' => __('tests.69-box-4'), 'reader' => 0, 'autofilled' => 0],
    false,
    false,
    ['content' => __('tests.69-box-5'), 'reader' => 0, 'autofilled' => 0],
    ['content' => __('tests.69-box-6'), 'reader' => 0, 'autofilled' => 0],
    false,
    ['content' => __('tests.69-box-7'), 'reader' => 0, 'autofilled' => 0],
    ['content' => __('tests.69-box-8'), 'reader' => 1, 'autofilled' => 0],
    ['content' => __('tests.69-box-9'), 'reader' => 1, 'autofilled' => 0],
    ['content' => __('tests.69-box-10'), 'reader' => 0, 'autofilled' => 1],
    ['content' => __('tests.69-box-11'), 'reader' => 0, 'autofilled' => 0],
];

bump($boxes);

$i = 0;

foreach ($boxes as $key => &$box) {
    if ($box) {
        if (! $box['autofilled']) {
            $i++;
        }

        if ($legacyTest->completed) {
            $box['classes'] = $box['autofilled'] || $legacyTest->rawResults[$i - 1] == $key ? 'right' : 'wrong';
            $box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[$legacyTest->rawResults[$i - 1]]['content'] ?? false);
        } else {
            $box['classes'] = $box['autofilled'] ? 'active locked' : 'droppable';
            $box['text'] = $box['autofilled'] ? $box['content'] : '';
        }
    }
}

$count = $i;

Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function ($count) {
        $boxes = LegacyView::getInstance()->get('boxes');

        $rightN = 0;

        $i = 0;

        foreach ($boxes as $key => $box) {
            if ($box && ! $box['autofilled']) {
                $i++;

                if ($_POST['field'][$i - 1] == $key) {
                    $rightN++;
                }
            }
        }

        return round($rightN / $count * 100);
    });
