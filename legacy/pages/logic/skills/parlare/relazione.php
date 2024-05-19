<?php

use LogicManager\TestLogic;

$count = 1;

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		return ((int) $_POST['field'][0]) * 10;
	});
