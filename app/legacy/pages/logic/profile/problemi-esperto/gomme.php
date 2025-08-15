<?php

use LogicManager\TestLogic;

\Legacy\LogicManager\TestLogic::setParameterCount(1)
	->setTestSubmitFunction(function () {
		return str_replace('.', '', $_POST['field'][0]) == 16000 ? 100 : 0;
	});
