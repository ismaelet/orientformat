<?php

use LogicManager\TestLogic;

$solution = $solution ?? [4, 5, 8, 1];
$answers = $answers ?? [1, 2, 3, 4, 5, 6, 7, 8];
$count = count($solution);

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$solution = \Legacy\System\Classes\LegacyView::get('solution');

		foreach ($_POST['field'] as $key => $answer) {
			if (strtolower($answer) != strtolower($solution[$key])) {
				return 0;
			}
		}

		return 100;
	});
