<?php

use LogicManager\TestLogic;

define('_SETS', [
	['1,3,5,e,9', 7],
	['10,e,6,4,2', 8],
	['e,21,17,13,9', 25],
	['5,10,20,e,80', 40],
	['64,32,16,8,e', 4],
	['2222,333,44,e', 5],
	['13,e,25,31,37', 19],
	['2,3,5,8,12,e', 17],
	['2,2,4,6,10,16,e', 26],
	['4,e,5,8,6,9', 7],
]);

$count = count(_SETS);

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$sets = _SETS;
		$correctResultCount = 0;

		foreach ($_POST['field'] as $key => $answer) {
			if ($answer == $sets[$key][1]) {
				$correctResultCount++;
			}
		}

		return round($correctResultCount / TestLogic::$parameterCount * 100);
	});
