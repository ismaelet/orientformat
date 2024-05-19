<?php

global $grade;

// setup page
$legacySectionId = 3;
$pageTitle = 'Resilienza';
$pageDesc = "Qui puoi controllare i risultati delle autovalutazioni relative alla resilienza.<br>
Compariranno solo gli studenti che hanno completato l'autovalutazione.";
$breadcrumbs[$pageTitle] = false;

// variables
$hasData = false;
$gradeTot = 0;
$gradeAverage = 0;
$graphData['max'] = 100;
$graphData['columns'] = [];

foreach ($grade->students as $student) {
	if (\Legacy\System\Classes\LegacyDB::exists("results WHERE userID = ? AND testID=49 AND completed=1", [\Illuminate\Support\Facades\Auth::id()])) {
		$graphData['columns'][$student->fullName] = Student\SectionTestResult::getResult(\Illuminate\Support\Facades\Auth::id(), $legacySectionId);
	}
}

// averages
$gradeAverage = Grade\SectionTestResult::getResult($grade->id, $legacySectionId);
$generalAverage = Grade\SectionTestResult::getResult(false, $legacySectionId);

$graphData['averages'] = [
	'Media della classe' => $gradeAverage,
	'Media dei partecipanti' => $generalAverage,
];

$graphData['legend'] = [
	'Media della classe: <strong>' . $gradeAverage . '</strong>',
	'Media dei partecipanti: <strong>' . $generalAverage . '</strong>',
];
