<?php

use LogicManager\TestLogic;

$count = 9;

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		return isset($_POST['skip-cbx']) ? 0 : 100;
	});
