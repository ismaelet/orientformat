<?php



global $class;



use Section\Results as SectionResults;



$sectionId = 4;

$graphData['max'] = 100;

$graphData['columns'] = [];



foreach ($class->students as $student) {

	if (\System\Classes\DBOld::count("results WHERE userID = ? AND testID IN ('7', '8', '9', '10', '11', '12') AND completed=1", [studentId()])) {

		$columnData = [];

		$columnData['subcolumns'] = [

			'Le mie emozioni' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 7]),

			'Come mi sento' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 8]),

			'Affrontare i problemi' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 9]),

			'Orientamento al futuro' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 10]),

			'La scuola' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 11]),

			'I rapporti con gli altri' => \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? AND completed=1 ORDER BY time DESC', [studentId(), 12]),

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
