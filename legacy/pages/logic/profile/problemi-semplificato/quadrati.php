<?php

use LogicManager\TestLogic;

$count = 1;
$correctAnswer = $correctAnswer ?? 6;

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$correctAnswer = \Legacy\System\Classes\LegacyView::get('correctAnswer');

		if ($_POST['field'][0] == $correctAnswer) {
			return 100;
		}

		return 0;
	});
