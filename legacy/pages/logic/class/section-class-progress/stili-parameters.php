<?php

global $grade;

// setup page
$legacySectionId = 1;
$pageTitle = 'Stili Cogniviti';
$pageDesc = "Qui puoi controllare i risultati delle autovalutazioni relative agli stili cognitivi. Per ogni stile è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.";
$breadcrumbs[$pageTitle] = false;

// variables
$graphData['max'] = 100;
$graphData['columns'] = [];
$styles = [1, 5, 2, 6, 3, 4, 8, 7,];

$gradeAverages = Grade\SectionTestResult::getRawResult($grade->id, 1)['values'];
$platformAverages = Grade\SectionTestResult::getRawResult(false, 1)['values'];

foreach ($styles as $styleId) {
	$columnData = [];

	$styleName = Student\SectionTestResult::parseToString(1, $styleId);

	$columnData['subcolumns'] = [
		'Media della classe' => $gradeAverages[$styleId] . '%',
		'Media dei participanti' => $platformAverages[$styleId] . '%',
	];

	$graphData['columns'][$styleName] = $columnData;
}

$graphData['legend'] = [
	'Media della classe',
	'Media dei partecipanti',
];

$graphData['legend-style'] = 'square';
