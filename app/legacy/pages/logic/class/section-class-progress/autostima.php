<?php

global $class;

use App\Legacy\LegacyDB;
use Illuminate\Support\Facades\Auth;
use Section\Results as SectionResults;

$sectionId = 4;

$graphData['max'] = 100;

$graphData['columns'] = [];

foreach ($class->students as $student) {

    if (LegacyDB::count("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1", [Auth::id()])) {

        $columnData = [];

        $columnData['subcolumns'] = [

            'Le mie emozioni' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 7]),

            'Come mi sento' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 8]),

            'Affrontare i problemi' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 9]),

            'Orientamento al futuro' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 10]),

            'La scuola' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 11]),

            'I rapporti con gli altri' => LegacyDB::find('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ? AND completed=1 ORDER BY time DESC', [Auth::id(), 12]),

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
