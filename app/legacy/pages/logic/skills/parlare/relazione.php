<?php

use LogicManager\TestLogic;

$count = 1;

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		return ((int) $_POST['field'][0]) * 10;
	});
