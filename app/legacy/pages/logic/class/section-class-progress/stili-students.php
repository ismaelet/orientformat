<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Student\SectionTestResult;

global $grade;

// setup page
$sectionId = 1;
$pageTitle = 'Stili Cogniviti';
$pageDesc = "Qui puoi controllare i risultati dell'autovalutazione relativa agli stili cognitivi.<br>Compariranno solo gli studenti che hanno completato l'autovalutazione.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.";
$breadcrumbs[$pageTitle] = false;

// variables
$graphData['max'] = 100;
$graphData['columns'] = [];

$groups = [
    1 => ['Visivo', 'apprende e ricorda attraverso immagini'],
    5 => ['Uditivo', 'è a suo agio quando può ascoltare'],
    2 => ['Collaborativo', 'lavora meglio in gruppo, mentre da solo si annoia'],
    6 => ['Autonomo', 'preferisce lavorare da solo, è a disagio nei lavori di gruppo'],
    3 => ['Globale', 'ricerca l’insieme, la totalità, trascurando i dettagli'],
    7 => ['Analitico', 'si concentra sui particolari, perdendo di vista l’insieme'],
    8 => ['Sistematico', 'predilige la precisione e la completezza, a costo di risultare dispersivo'],
    4 => ['Intuitivo', 'vuole arrivare subito alla conclusione, rischiando soluzioni avventate'],
];

foreach ($grade->students as $student) {
    if (DB::selectOne('SELECT 1 FROM '.("results WHERE userID = ? AND testID IN ('30') AND completed=1").' LIMIT 1', (array) ([Auth::id()])) !== null) {

        $columnData = [];
        $columnData['subcolumns'] = [];
        $CondensedTestResult = SectionTestResult::getRawResult(Auth::id(), $sectionId);

        foreach ($groups as $styleId => $styleName) {
            $columnData['subcolumns'][$styleName[0]] = $CondensedTestResult[$styleId].'%';
        }

        $graphData['columns'][$student->fullName] = $columnData;
    }
}
