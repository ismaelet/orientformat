<?php

global $class;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Section\Results as SectionResults;

$sectionId = 4;

$graphData['max'] = 100;

$graphData['columns'] = [];

foreach ($class->students as $student) {

    if (DB::scalar('SELECT COUNT(*) FROM '.("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1"), (array) ([Auth::id()]))) {

        $columnData = [];

        $columnData['subcolumns'] = [

            'Le mie emozioni' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 7])) ?? false,

            'Come mi sento' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 8])) ?? false,

            'Affrontare i problemi' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 9])) ?? false,

            'Orientamento al futuro' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 10])) ?? false,

            'La scuola' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 11])) ?? false,

            'I rapporti con gli altri' => DB::scalar('SELECT '.('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC').' LIMIT 1', (array) ([Auth::id(), 12])) ?? false,

        ];

        $graphData['columns'][$student->fullName] = $columnData;
    }
}

// averages

$generalAverage = SectionResults::getGeneralResults($sectionId);

$classAverage = SectionResults::getGeneralResults($sectionId, $class->id);

$graphData['averages'] = [

    'Media della classe' => $classAverage,

    'Media dei partecipanti' => $generalAverage,

];

$graphData['legend'] = [

    'Media della classe ('.SectionResults::resultByValue($sectionId, $classAverage).')',

    'Media dei partecipanti ('.SectionResults::resultByValue($sectionId, $generalAverage).')',

    'Media dello studente',

];
