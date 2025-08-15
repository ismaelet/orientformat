<?php

define('_RIGHT_COUNT', 5);

use LogicManager\TestLogic;

$legacyTestCount = 1;

\Legacy\LogicManager\TestLogic::setParameterCount($legacyTestCount)
	->setTestSubmitFunction(function () {
		$right = _RIGHT_COUNT;

		return $_POST['field'][0] == $right ? 100 : 0;
	});
