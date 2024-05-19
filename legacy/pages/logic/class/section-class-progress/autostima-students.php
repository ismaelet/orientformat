<?php

global $grade;


// setup page
$sectionId = 4;
$pageTitle = 'Autostima';
$pageDesc = "Qui puoi controllare i risultati delle autovalutazioni relative all'autostima.<br>Compariranno solo gli studenti che hanno completato per lo meno una autovalutazione.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.";
$breadcrumbs[$pageTitle] = false;

// variables
$sectionId = 4;
$graphData['max'] = 100;
$graphData['columns'] = [];

foreach ($grade->students as $student) {
	if (\App\Legacy\LegacyDB::exists("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1", [\Illuminate\Support\Facades\Auth::id()])) {
		$columnData = [];
		$studentResults = [];
		$rawResults = Student\SectionTestResult::getRawResult(\Illuminate\Support\Facades\Auth::id(), $sectionId);

		foreach ($rawResults as $resultId => $resultValue) {
			$resultName = \App\Legacy\LegacyDB::find('title FROM ' . Test::TABLE . ' WHERE id = ?', [$resultId]);
			$studentResults[$resultName] = Student\SectionTestResult::parseToString($sectionId, $resultValue);
		}

		$columnData['subcolumns'] = $studentResults;
		$graphData['columns'][$student->fullName] = $columnData;
	}
}

// averages
$gradeAverage = Grade\SectionTestResult::getResult($grade->id, $sectionId);
$generalAverage = Grade\SectionTestResult::getResult(false, $sectionId);

$graphData['averages'] = [
	'Media della classe' => $gradeAverage,
	'Media dei partecipanti' => $generalAverage,
];

$graphData['legend'] = [
	'Media della classe ' . $gradeAverage,
	'Media dei partecipanti ' . $generalAverage,
	'Media dello studente',
];
