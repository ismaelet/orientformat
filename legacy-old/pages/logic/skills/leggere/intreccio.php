<?php

use LogicManager\TestLogic;

$test = test();

// setup variables
$boxes = [
	false,
	['content' => "Il ragazzo acquista le patate fritte", 'reader' => 0, 'autofilled' => 0],
	false,
	false,
	['content' => "Versa \"troppo\" aceto", 'reader' => 0, 'autofilled' => 1],
	false,
	['content' => "Sono poveri", 'reader' => 1, 'autofilled' => 0],
	['content' => "La padrona si arrabbia ", 'reader' => 0, 'autofilled' => 0],
	false,
	false,
	['content' => "Rincorre il ragazzo", 'reader' => 0, 'autofilled' => 0],
	['content' => "Il ragazzo si spaventa", 'reader' => 0, 'autofilled' => 0],
	false,
	['content' => "Interviene il salvatore", 'reader' => 0, 'autofilled' => 0],
	['content' => "Prova irritazione / disgusto / compassione", 'reader' => 1, 'autofilled' => 0],
	['content' => "Prova vergogna / smarrimento", 'reader' => 1, 'autofilled' => 0],
	['content' => "La donna piange e ritorna a casa", 'reader' => 0, 'autofilled' => 1],
	['content' => "Riflessioni sulla poesia nella vita", 'reader' => 0, 'autofilled' => 0],
];

bump($boxes);

$i = 0;

foreach ($boxes as $key => &$box) {
	if ($box) {
		if (!$box['autofilled']) {
			$i++;
		}

		if ($test->completed) {
			$box['classes'] = $box['autofilled'] || $test->rawResults[$i - 1] == $key ? 'right' : 'wrong';
			$box['text'] = $box['autofilled'] ? $box['content'] : ($boxes[$test->rawResults[$i - 1]]['content'] ?? false);
		} else {
			$box['classes'] = $box['autofilled'] ? 'active locked' : 'droppable';
			$box['text'] = $box['autofilled'] ? $box['content'] : '';
		}
	}
}

$count = $i;

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$boxes = View::getInstance()->get('boxes');

		$rightN = 0;

		$i = 0;

		foreach ($boxes as $key => $box) {
			if ($box && !$box['autofilled']) {
				$i++;

				if ($_POST['field'][$i - 1] == $key) {
					$rightN++;
				}
			}
		}

		return round($rightN / $count * 100);
	});
