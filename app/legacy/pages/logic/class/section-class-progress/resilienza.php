<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Student\SectionTestResult;

global $grade;

// setup page
$sectionId = 3;
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
    if (DB::selectOne('SELECT 1 FROM '.('results WHERE userID = ? AND testID=49 AND completed=1').' LIMIT 1', (array) ([Auth::id()])) !== null) {
        $graphData['columns'][$student->fullName] = SectionTestResult::getResult(Auth::id(), $sectionId);
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
    'Media della classe: <strong>'.$gradeAverage.'</strong>',
    'Media dei partecipanti: <strong>'.$generalAverage.'</strong>',
];
