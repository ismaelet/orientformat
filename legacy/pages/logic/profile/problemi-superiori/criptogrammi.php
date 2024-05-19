<?php

use LogicManager\TestLogic;

$texts = [
	'Forse ricordi quando ti dissi un giorno <br>
	Che certo non aspetterò più di imbarcarmi <br>
	Un’ altra volta nella solita nave? <br>
	Avrei cercato una locanda in campagna <br>
	Per dimenticarmi finalmente del mare. <br>
	Ora guardo il porto dal sole delle colline.',

	'Il sapore aspro dell’ avventura <br>
	Mi spinge verso l’ orizzonte nuovo. <br>
	Arrivo con passi spavaldi <br>
	E non chiedo ciò che sarà. <br>
	All’ estremo confine dello spazio <br>
	Troverò la sorgente dell’ alba.',

	'Lo stormo si perde nel blu. <br>
	tornerà straniero il sole. <br>
	Da noi è l\'autunno ormai. <br>
	domani nella casa una donna sola sarà. <br>
	Al tramonto affida, come spia ignota, i pensieri.'
];

$correctResults = [
	1 => [4, 11, 18, 24, 30, 35],
	2 => [1, 11, 12, 21, 22, 31],
	3 => [1, 8, 13, 19, 27],
];

$legacyTestResults = test()->completed ? _parse_results(test()->rawResults) : null;

\LogicManager\TestLogic::setTestSubmitFunction(function () {
	$correctResults = \Legacy\System\Classes\LegacyView::getInstance()->get('correctResults');
	$correctResultCount = 0;

	$results = _parse_results($_POST['field']);

	foreach ($results as $cryptogramId => $cryptogramResult) {
		if ($cryptogramResult == $correctResults[$cryptogramId]) {
			$correctResultCount++;
		}
	}

	return round($correctResultCount / count($results) * 100);
});

function _parse_results(array $rawResults) {
	$results = [
		1 => [],
		2 => [],
		3 => [],
	];

	foreach ($rawResults as $result) {
		$result = explode('-', $result);
		$cryptogramId = $result[0];
		$value = $result[1];

		$results[$cryptogramId][] = $value;
	}

	return $results;
}
