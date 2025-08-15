<?php

use LogicManager\TestLogic;

$characters = [
	[
		'text' => __('tests.124-description-1'),
		'weaponId' => 4
	],
	[
		'text' => __('tests.124-description-2'),
		'weaponId' => 3
	],
	[
		'text' => __('tests.124-description-3'),
		'weaponId' => 1
	],
	[
		'text' => __('tests.124-description-4'),
		'weaponId' => 2
	],
];

$correctResults = [4, 3, 1, 2];

\Legacy\LogicManager\TestLogic::setParameterCount(count($characters))
	->setTestSubmitFunction(function ($count) {
		$correctCount = 0;
		$correctResults = \App\Legacy\LegacyView::get('correctResults');

		foreach ($correctResults as $resultKey => $correctResult) {
			if (isset($_POST['field'][$resultKey]) && $_POST['field'][$resultKey] == $correctResult) {
				$correctCount++;
			}
		}

		return round($correctCount / $count * 100);
	});
