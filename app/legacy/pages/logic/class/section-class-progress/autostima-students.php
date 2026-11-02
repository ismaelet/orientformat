<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Student\SectionTestResult;

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
    if (DB::selectOne('SELECT 1 FROM '.("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1").' LIMIT 1', (array) ([Auth::id()])) !== null) {
        $columnData = [];
        $studentResults = [];
        $rawResults = SectionTestResult::getRawResult(Auth::id(), $sectionId);

        foreach ($rawResults as $resultId => $resultValue) {
            $resultName = DB::scalar('SELECT '.('title FROM '.Test::TABLE.' WHERE id = ?').' LIMIT 1', (array) ([$resultId])) ?? false;
            $studentResults[$resultName] = SectionTestResult::parseToString($sectionId, $resultValue);
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
    'Media della classe '.$gradeAverage,
    'Media dei partecipanti '.$generalAverage,
    'Media dello studente',
];
