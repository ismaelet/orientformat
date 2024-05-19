<?php

define('_RIGHT_COUNT', 5);

use LogicManager\TestLogic;

$testCount = 1;

Test\Legacy\System\Classes\Logic::setParameterCount($testCount)
	->setTestSubmitFunction(function () {
		$right = _RIGHT_COUNT;

		return $_POST['field'][0] == $right ? 100 : 0;
	});
