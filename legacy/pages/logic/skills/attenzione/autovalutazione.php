<?php

use LogicManager\TestLogic;

$questions = [
	'Mi accorgo quando mi distraggo',
	'So che cosa mi distrae',
	'Riesco a recuperare l’attenzione',
	'So mantenere l’attenzione per il tempo necessario',
	'Ho una mia strategia per evitare di distrarmi',
	'Riesco a svolgere diverse attività nello stesso tempo'
];

$count = count($questions);

bump($questions);

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$max = 4 * $count;
		$score = 0;

		foreach ($_POST['field'] as $val) {
			$score += $val;
		}

		return round($score / $max * 100, 0);
	});
