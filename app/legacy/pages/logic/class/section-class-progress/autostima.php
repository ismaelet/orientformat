<?php



global $class;



use Section\Results as SectionResults;



$sectionId = 4;

$graphData['max'] = 100;

$graphData['columns'] = [];



foreach ($class->students as $student) {

	if (\App\Legacy\LegacyDB::count("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1", [\Illuminate\Support\Facades\Auth::id()])) {

		$columnData = [];

		$columnData['subcolumns'] = [

			'Le mie emozioni' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 7]),

			'Come mi sento' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 8]),

			'Affrontare i problemi' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 9]),

			'Orientamento al futuro' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 10]),

			'La scuola' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 11]),

			'I rapporti con gli altri' => \App\Legacy\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 12]),

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

	'Media della classe (' . SectionResults::resultByValue($sectionId, $classAverage) . ')',

	'Media dei partecipanti (' . SectionResults::resultByValue($sectionId, $generalAverage) . ')',

	'Media dello studente',

];
