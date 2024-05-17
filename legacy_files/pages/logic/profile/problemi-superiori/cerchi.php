<?php

use LogicManager\TestLogic;

$patterns = [
	[3, 1, 2],
	[2, 3, 1],
	[3, 2, 1],
	[1, 2, 3],
];

$correctSolution = 3;

TestLogic::setParameterCount(1)
	::setTestSubmitFunction(function () {
		$correctSolution = ViewOld::getInstance()->get('correctSolution');

		return $_POST['field'][0] == $correctSolution ? 100 : 0;
	});
