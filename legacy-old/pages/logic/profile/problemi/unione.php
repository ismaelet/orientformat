<?php

use LogicManager\TestLogic;

$count = 9;

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		return isset($_POST['skip-cbx']) ? 0 : 100;
	});
