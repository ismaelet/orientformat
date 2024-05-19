<?php

global $grade;

// setup page
$legacySectionId = 9;
$testId = 16;
$pageTitle = 'Attenzione - Autovalutazione';
$pageDesc = 'Qui puoi controllare i risultati dell\'autovalutazione. Per ogni campo è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.';
$breadcrumbs[$pageTitle] = false;

// variables
$graphData['max'] = 100;
$graphData['columns'] = [];

// results
$gradeAverages = Grade\TestTestResult::getRawResult($grade->id, $testId)['values'];
$gradeAverage = round(array_sum($gradeAverages) / count($gradeAverages));

foreach ($gradeAverages as $resultName => $resultValue) {
	$graphData['columns'][$resultName] = $gradeAverages[$resultName] . '%';
}

// legend
$graphData['averages'] = [
	'Media della classe' => $gradeAverage,
];

$graphData['legend'] = [
	'Media della classe: <strong>' . $gradeAverage . '%</strong>',
];
