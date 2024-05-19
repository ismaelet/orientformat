<?php

use LogicManager\TestLogic;

$legacyTest = test();

$boxes = [
	1 => ['content' => "istinto", 'autofilled' => 0, 'type' => 1],
	2 => ['content' => "di", 'autofilled' => 1, 'type' => 2],
	3 => ['content' => "imparare", 'autofilled' => 0, 'type' => 1, 'alternatives' => [4]],
	4 => ['content' => "insegnare", 'autofilled' => 0, 'type' => 1, 'alternatives' => [3]],
	5 => ['content' => "l’arte della caccia", 'autofilled' => 1, 'type' => 1],
	6 => ['content' => "madri", 'autofilled' => 1, 'type' => 1],
	7 => ['content' => "cuccioli", 'autofilled' => 0, 'type' => 1],
	8 => ['content' => "portano", 'autofilled' => 0, 'type' => 2],
	9 => ['content' => "guardano", 'autofilled' => 0, 'type' => 2, 'alternatives' => [12, 13]],
	10 => ['content' => "si cibano della", 'autofilled' => 0, 'type' => 2,],
	11 => ['content' => "si cibano della", 'autofilled' => 1, 'type' => 2],
	12 => ['content' => "giocano", 'autofilled' => 0, 'type' => 2, 'alternatives' => [9, 13]],
	13 => ['content' => "si allenano", 'autofilled' => 0, 'type' => 2, 'alternatives' => [9, 12]],
	14 => ['content' => "preda morta", 'autofilled' => 0, 'type' => 1],
	15 => ['content' => "imparano i placcaggi", 'autofilled' => 0, 'type' => 2],
	16 => ['content' => "preda tramortita", 'autofilled' => 0, 'type' => 1],
	17 => ['content' => "se la cavano da soli", 'autofilled' => 1, 'type' => 2],
	18 => ['content' => "preda viva", 'autofilled' => 0, 'type' => 1],
	19 => ['content' => "conseguenze per il	padrone?", 'autofilled' => 1, 'type' => 1],
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

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$boxes = \Legacy\System\Classes\LegacyView::getInstance()->get('boxes');

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
