<?php



global $class;



use Section\Results as SectionResults;



$legacySectionId = 4;

$graphData['max'] = 100;

$graphData['columns'] = [];



foreach ($class->students as $student) {

	if (\Legacy\System\Classes\LegacyDB::count("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1", [\Illuminate\Support\Facades\Auth::id()])) {

		$columnData = [];

		$columnData['subcolumns'] = [

			'Le mie emozioni' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 7]),

			'Come mi sento' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 8]),

			'Affrontare i problemi' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 9]),

			'Orientamento al futuro' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 10]),

			'La scuola' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 11]),

			'I rapporti con gli altri' => \Legacy\System\Classes\LegacyDB::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [\Illuminate\Support\Facades\Auth::id(), 12]),

		];

		$graphData['columns'][$student->fullName] = $columnData;
	}
}



// averages

$generalAverage = SectionResults::getGeneralResults($legacySectionId);

$classAverage = SectionResults::getGeneralResults($legacySectionId, $class->id);



$graphData['averages'] = [

	'Media della classe' => $classAverage,

	'Media dei partecipanti' => $generalAverage,

];



$graphData['legend'] = [

	'Media della classe (' . SectionResults::resultByValue($legacySectionId, $classAverage) . ')',

	'Media dei partecipanti (' . SectionResults::resultByValue($legacySectionId, $generalAverage) . ')',

	'Media dello studente',

];
