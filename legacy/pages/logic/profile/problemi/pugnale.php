<?php

use LogicManager\TestLogic;

$characters = [
	[
		'text' => 'La mia arma non è un pugnale.',
		'weaponId' => 4
	],
	[
		'text' => 'La mia arma ha la punta rivolta verso l\'alto.',
		'weaponId' => 3
	],
	[
		'text' => 'L\'arma con la punta non pericolosa non è di un uomo.',
		'weaponId' => 1
	],
	[
		'text' => 'La mia arma non ha la punta rivolta verso il basso.',
		'weaponId' => 2
	],
];

$correctResults = [4, 3, 1, 2];

Test\Legacy\System\Classes\Logic::setParameterCount(count($characters))
	->setTestSubmitFunction(function ($count) {
		$correctCount = 0;
		$correctResults = \Legacy\System\Classes\LegacyView::get('correctResults');

		foreach ($correctResults as $resultKey => $correctResult) {
			if (isset($_POST['field'][$resultKey]) && $_POST['field'][$resultKey] == $correctResult) {
				$correctCount++;
			}
		}

		return round($correctCount / $count * 100);
	});
