<?php

$solution = $solution ?? [4, 5, 8, 1];
$answers = $answers ?? [1, 2, 3, 4, 5, 6, 7, 8];
$count = count($solution);

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () use ($solution) {
		foreach ($_POST['field'] as $key => $answer) {
			if (strtolower($answer) != strtolower($solution[$key])) {
				return 0;
			}
		}

		return 100;
	});
