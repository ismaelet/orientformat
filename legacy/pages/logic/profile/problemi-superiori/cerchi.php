<?php

use LogicManager\TestLogic;

$patterns = [
	[3, 1, 2],
	[2, 3, 1],
	[3, 2, 1],
	[1, 2, 3],
];

$correctSolution = 3;

\LogicManager\TestLogic::setParameterCount(1)
	::setTestSubmitFunction(function () {
		$correctSolution = \Legacy\System\Classes\LegacyView::getInstance()->get('correctSolution');

		return $_POST['field'][0] == $correctSolution ? 100 : 0;
	});
