<?php

use LogicManager\TestLogic;

$test = test();

$boxes = [
	['content' => "L'albatro", 'autofilled' => 1],
	['content' => "il piccolo muore", 'autofilled' => 1],
	['content' => "un solo uovo molto grosso", 'autofilled' => 0],
	['content' => "80 giorni di incubazione", 'autofilled' => 0],
	['content' => "cure per 9 mesi", 'autofilled' => 0],
	['content' => "i genitori si danno il cambio", 'autofilled' => 1],
	['content' => "scambio di carezze", 'autofilled' => 0],
	['content' => "riproduzione dopo un anno", 'autofilled' => 0],
	['content' => "si rinforza il legame", 'autofilled' => 0],
	['content' => "unione permanente", 'autofilled' => 0],
	['content' => "fedeltà dell’albatro", 'autofilled' => 1],
];

bump($boxes);

$i = 0;
foreach ($boxes as $key => &$box) {
	if (!$box['autofilled']) {
		$i++;
	}

	if ($test->completed) {
		$box['classes'] = $box['autofilled'] || $test->rawResults[$i - 1] == $key ? 'right' : 'wrong';
		$box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[$test->rawResults[$i - 1]]['content'] ?? false);
	} else {
		$box['classes'] = $box['autofilled'] ? 'active' : 'droppable';
		$box['text'] = $box['autofilled'] ? $box['content'] : '';
	}
}

$count = $i;

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$boxes = \Legacy\System\Classes\LegacyView::getInstance()->get('boxes');

		$rightN = 0;

		$i = 0;
		foreach ($boxes as $key => $box) {
			if (!$box['autofilled']) {

				$i++;

				if ($_POST['field'][$i - 1] == $key) {
					$rightN++;
				}
			}
		}

		return round($rightN / $count * 100);
	});
