<?php

use Activity\Result\TestResult;
use app\Models\Helpers\Notification;

/* TEMP: set students personal data */
/*

$tempStudents = DB::select('userId FROM students WHERE status=1 AND userId NOT IN (SELECT studentId FROM students_data)');

while ($tempStudent = $tempStudents->fetch_assoc()) {
	$tempData = [];
	$tempSurveryData = [];

	if ($tempSurvery = DB::find('results FROM review_results WHERE studentId = ? AND FIND_IN_SET(reviewId, "1,2")', [$tempStudent['userId']])) {
		foreach (explode(',', $tempSurvery) as $tempSurveryVal) {
			$tempSurveryVal = explode('=', $tempSurveryVal);
			$tempSurveryData[$tempSurveryVal[0]] = $tempSurveryVal[1] ?? false;
		}

		$tempData['gender'] = $tempSurveryData['s1d1'] ?? 9;
		$tempData['decided'] = $tempSurveryData['s2d1'] ?? 0;
		$newDegreeLevel = isset($tempSurveryData['s4d1_1']) && isset($tempSurveryData['s4d1_2']) ? max($tempSurveryData['s4d1_1'], $tempSurveryData['s4d1_2']) : 7;

		switch ($newDegreeLevel) {
			case 5:
				$oldDegreeLevel = 8;
				break;
			case 6:
			case 7:
				$oldDegreeLevel = 0;
				break;
			default:
				$oldDegreeLevel = $newDegreeLevel;
				break;
		}

		$tempData['degree'] = $oldDegreeLevel;

		if (!isset($tempSurveryData['s4d1_1'])) error_log('Parents title not defined for student ID: ' . $tempStudent['userId']);
	} else if (
		DB::exists('survey_end WHERE userID = ?', [$tempStudent['userId']]) ||
		DB::exists('survey_start WHERE userID = ?', [$tempStudent['userId']])
	) {
		$tempSurvery = DB::find('results FROM survey_end WHERE userID = ?', [$tempStudent['userId']]);
		if (!$tempSurvery) $tempSurvery = DB::find('results FROM survey_start WHERE userID = ?', [$tempStudent['userId']]);

		foreach (explode(',', $tempSurvery) as $tempSurveryVal) {
			$tempSurveryVal = explode('=', $tempSurveryVal);
			$tempSurveryData[$tempSurveryVal[0]] = $tempSurveryVal[1] ?? false;
		}

		if (empty($tempSurveryData['s3d1_ma']) || $tempSurveryData['s3d1_ma'] > 8) $tempSurveryData['s3d1_ma'] = 0;
		if (empty($tempSurveryData['s3d1_pa']) || $tempSurveryData['s3d1_pa'] > 8) $tempSurveryData['s3d1_pa'] = 0;

		$tempData['gender'] = 9;
		$tempData['decided'] = $tempSurveryData['s1d1'] ?? 0;
		$tempData['degree'] = max($tempSurveryData['s3d1_pa'], $tempSurveryData['s3d1_ma']);
	}

	if (!empty($tempData)) {
		DB::add('students_data (studentId, gender, decided, degree)', [$tempStudent['userId'], $tempData['gender'], $tempData['decided'], $tempData['degree']]);
	}
}
/* END TEMP */

/* TEMP: update students stuatus based on user status */
/*
$tempStudents = DB::select(User::INDEX . ' FROM ' . User::TABLE . ' WHERE status = 0 AND ' . User::GROUP_INDEX . ' = 0 AND ' . User::INDEX . ' NOT IN (SELECT ' . Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE status = 0)');

while ($tempStudent = $tempStudents->fetch_assoc()) {
	DB::update(Student::TABLE . ' SET status = 0 WHERE ' . Student::INDEX . ' = ?', [$tempStudent['id']]);
}

/* END TEMP */

// setup page
$functionalities = [
	[
		'title' => 'Simulazione studente',
		'subtitle' => 'Per esplorare le attività',
		'desc' => 'Qui è possibile vedere quali saranno le attività proposte ai tuoi studenti e testare come funzionano.',
		'url' => client_url('/teacher/simulation'),
		'slug' => 'simulation'
	],
	[
		'title' => 'Saperne di più',
		'subtitle' => 'Per approfondire',
		'desc' => 'Qui potrai accedere ad agili schede di approfondimento, arricchite da un Glossario ipertestuale.',
		'url' => client_url('/teacher/know-more'),
		'slug' => 'know-more'
	],
	[
		'title' => 'Contattaci',
		'subtitle' => 'Per dubbi o chiarimenti',
		'desc' => 'Se hai qualche dubbio sul funzionamento della piattaforma o hai riscontrato qualche difficoltà, puoi contattarci qui.',
		'url' => client_url('/teacher/support/open-ticket'),
		'slug' => 'support'
	],
	[
		'title' => 'Modulistica',
		'subtitle' => 'Documenti e informative',
		'desc' => 'Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span class="txt-sbold">Consiglio orientativo</span> e altri documenti di supporto.',
		'url' => client_url('/teacher/documents'),
		'slug' => 'documents'
	],
	// [
	// 	'title' => 'Percorsi',
	// 	'subtitle' => '',
	// 	'desc' => 'Qui puoi visualizzare i vari tipi di percorso che potrai seguire nelle tue classi.',
	// 	'url' => client_url('/teacher/paths'),
	// 	'slug' => 'paths'
	// ],
	[
		'title' => 'Impostazioni account',
		'subtitle' => '',
		'desc' => 'Qui puoi cambiare i dati associati al tuo account e modificare le impostazioni di base.',
		'url' => client_url('/teacher/settings'),
		'slug' => 'settings'
	],
];

// $feed = [];

// if (teacher()->studentIdsString) {
// 	$feedEntriesData = DB::select(TestResult::USER_INDEX . ', ' . TestResult::TEST_INDEX . ' FROM ' . TestResult::TABLE . ' WHERE FIND_IN_SET (' . TestResult::USER_INDEX . ', ?) ORDER BY time DESC LIMIT 10', [teacher()->studentIdsString]);

// 	while ($feedEntryData = $feedEntriesData->fetch_assoc()) {
// 		$feedEntry = [];
// 		$feedStudent = new UserSystem\Student($feedEntryData[TestResult::USER_INDEX]);
// 		$feedTest = new Activity\Test($feedEntryData[TestResult::TEST_INDEX]);
// 		$feedEntry['studentName'] = $feedStudent->fullName;
// 		$feedEntry['text'] = 'ha completato l\'attività <strong>' . $feedTest->fullTitle . '</strong>';

// 		$feed[] = $feedEntry;
// 	}
// }

$feed = Notification::getAll();

// collaboration requests
$collaborations = DB::select('* FROM grade_requests WHERE referentId = ?', [teacherId()]);

if (isset($_POST['accept-collaboration'])) {
	$collaborationId = $_POST['accept-collaboration'];
	$collaborationData = DB::row('* FROM grade_requests WHERE id = ?', [$collaborationId]);

	$gradeId = DB::update("teachers SET classes=CONCAT(classes, '," . $collaborationData['gradeId'] . "') WHERE userId = ?", [$collaborationData['teacherId']]);

	DB::delete('grade_requests WHERE id = ?', [$collaborationData['id']]);

	redirect();
}

if (isset($_POST['decline-collaboration'])) {
	$collaborationId = $_POST['decline-collaboration'];

	DB::delete('grade_requests WHERE id = ?', [$collaborationId]);

	redirect();
}
