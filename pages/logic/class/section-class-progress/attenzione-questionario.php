<?php

global $grade;

// setup page
$sectionId = 9;
$testId = 17;
$pageTitle = 'Attenzione - Autovalutazione';
$pageDesc = 'Qui puoi controllare i risultati dell\'autovalutazione.<br>Valori bassi indicano una concentrazione migliore e una propensione minore all\'iperattività.<br> Per ogni campo è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.';
$breadcrumbs[$pageTitle] = false;

// variables
$graphData['max'] = 100;
$graphData['columns'] = [];

// variables
$graphData['columns'] = [];

foreach ($grade->students as $student) {
	$result = Activity\Result\CondensedTestResult::getRawResult(studentId(), $testId);

	if ($result) {
		foreach ($result as $resultName => $resultValue) {
			$studentResults[$resultName] = Activity\Result\CondensedTestResult::parseToString($testId, $resultValue);
		}

		$columnData['subcolumns'] = $studentResults;
		$graphData['columns'][$student->fullName] = $columnData;
	}
}

// averages
$averages = Grade\TestTestResult::getRawResult($grade->id, $testId);
$attenzioneAverage = Activity\Result\CondensedTestResult::parseToString($testId, $averages['values']['Perdita di attenzione']);
$iperattivitaAverage = Activity\Result\CondensedTestResult::parseToString($testId, $averages['values']['Iperattività']);

$graphData['averages'] = [
	'Media della difficoltà a mantenere l\'attenzione: ' => $attenzioneAverage,
	'Media dell\'iperattivià' => $iperattivitaAverage,
];

$graphData['legend'] = [
	'Media della difficoltà a mantenere l\'attenzione: <strong>' . $attenzioneAverage . '</strong>',
	'Media dell\'iperattivià: <strong>' . $iperattivitaAverage . '</strong>',
];
