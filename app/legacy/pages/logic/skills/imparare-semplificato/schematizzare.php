<?php

use LogicManager\TestLogic;

$legacyTest = legacy_test();

$boxes = [
	1 => ['content' => __('tests.133-box-1'), 'autofilled' => 0, 'type' => 1],
	2 => ['content' => __('tests.133-box-2'), 'autofilled' => 1, 'type' => 2],
	3 => ['content' => __('tests.133-box-3'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [4]],
	4 => ['content' => __('tests.133-box-4'), 'autofilled' => 0, 'type' => 1, 'alternatives' => [3]],
	5 => ['content' => __('tests.133-box-5'), 'autofilled' => 1, 'type' => 1],
	6 => ['content' => __('tests.133-box-6'), 'autofilled' => 1, 'type' => 1],
	7 => ['content' => __('tests.133-box-7'), 'autofilled' => 0, 'type' => 1],
	8 => ['content' => __('tests.133-box-8'), 'autofilled' => 0, 'type' => 2],
	9 => ['content' => __('tests.133-box-9'), 'autofilled' => 0, 'type' => 2, 'alternatives' => [12, 13]],
	10 => ['content' => __('tests.133-box-10'), 'autofilled' => 0, 'type' => 2],
	11 => ['content' => __('tests.133-box-11'), 'autofilled' => 1, 'type' => 2],
	12 => ['content' => __('tests.133-box-12'), 'autofilled' => 0, 'type' => 2, 'alternatives' => [9, 13]],
	13 => ['content' => __('tests.133-box-13'), 'autofilled' => 0, 'type' => 2, 'alternatives' => [9, 12]],
	14 => ['content' => __('tests.133-box-14'), 'autofilled' => 0, 'type' => 1],
	15 => ['content' => __('tests.133-box-15'), 'autofilled' => 0, 'type' => 2],
	16 => ['content' => __('tests.133-box-16'), 'autofilled' => 0, 'type' => 1],
	17 => ['content' => __('tests.133-box-17'), 'autofilled' => 1, 'type' => 2],
	18 => ['content' => __('tests.133-box-18'), 'autofilled' => 0, 'type' => 1],
	19 => ['content' => __('tests.133-box-19'), 'autofilled' => 1, 'type' => 1],
];

$i = 0;
foreach ($boxes as $key => &$box) {
	if (!$box['autofilled']) {
		$i++;
	}

	if ($legacyTest->completed) {
		$box['classes'] = $box['autofilled'] || $legacyTest->rawResults[$i - 1] == $key || (isset($box['alternatives']) && in_array($legacyTest->rawResults[$i - 1], $box['alternatives'])) ? 'right' : 'wrong';
		$box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[$legacyTest->rawResults[$i - 1]]['content'] ?? false);
	} else {
		$box['classes'] = $box['autofilled'] ? 'active' : 'droppable';
		$box['text'] = $box['autofilled'] ? $box['content'] : '';
	}
}

$count = $i;

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$boxes = \App\Legacy\LegacyView::getInstance()->get('boxes');

		$rightN = 0;
		$i = 0;

		foreach ($boxes as $key => $box) {
			if (!$box['autofilled']) {
				$i++;
				$value = $_POST['field'][$i - 1];

				if ($value == $key || (isset($box['alternatives']) && in_array($value, $box['alternatives']))) {
					$rightN++;
				}
			}
		}

		return round($rightN / $count * 100);
	});
