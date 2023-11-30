<?php

use LogicManager\TestLogic;

$count = 1;
$correctAnswer = $correctAnswer ?? 6;

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$correctAnswer = View::get('correctAnswer');

		if ($_POST['field'][0] == $correctAnswer) {
			return 100;
		}

		return 0;
	});
