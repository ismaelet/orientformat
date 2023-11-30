<?php

use LogicManager\TestLogic;

$riddles = [
	['wyxj', 'è sempre teso', 'ARCO'],
	['yjxw', 'la voce del raffreddore', 'ROCA'],
	['jyxw', 'cetaceo di cattiva fama', 'ORCA'],
	['xwyj', 'affettuoso, ma anche poco economico', 'CARO'],
];

TestLogic::setParameterCount(count($riddles))
	->setTestSubmitFunction(function ($count) {
		$riddles = View::get('riddles');
		$rightAnswers = 0;

		foreach ($riddles as $riddleKey => $riddle) {
			if (strtolower(trim($_POST['field'][$riddleKey] ?? '')) == strtolower($riddle[2])) {
				$rightAnswers++;
			}
		}

		return round($rightAnswers / $count * 100);
	});
