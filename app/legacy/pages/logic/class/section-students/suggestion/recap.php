<?php

use \Legacy\Activity\Result\Handler\StudentSectionResult;
use \Legacy\Activity\Result\Handler\StudentTestResult;
use \Legacy\UserSystem\Student;

$studentId = $_GET['studentId'] ?? null;
$student = new Student($studentId);
$profile = $student->profile;
$beginnerChoice = $profile->dynamicChoice([1, 2, 4, 5]);
$endChoice = $profile->dynamicChoice([3, 6]);

$results = [
	'ascoltare' => (new StudentSectionResult(11, $studentId))->result,
	'parlare' => (new StudentSectionResult(12, $studentId))->result,
	'leggere' => (new StudentSectionResult(39, $studentId))->result,
	'scrivere' => (new StudentSectionResult(14, $studentId))->result,
	'attenzione' => (new StudentSectionResult(9, $studentId))->result,
	'ricordare' => (new StudentSectionResult(10, $studentId))->result,
	'problemi' => (new StudentSectionResult(5, $studentId))->result,
	'imparare' => (new StudentSectionResult(40, $studentId))->result,
	'creatività' => (new StudentSectionResult(17, $studentId))->detailedResult,
	'motivazione' => (new StudentSectionResult(7, $studentId))->result,
	'interessi' => (new StudentSectionResult(24, $studentId))->result,
];


// fetch advices
$advices = [];
$advicesRes = \App\Legacy\LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

while ($advice = $advicesRes->fetch_assoc()) {
	$advices[$advice['id']] = $advice['advice'];
}

// add advice
if (isset($_POST['submit'])) {
	$advices = [];

	foreach ($_POST['advice'] as $advice) {
		if ($advice) {
			$advices[] = $advice;
		}
	}

	$advices = implode(',', $advices);

	if (empty($advices)) {
		\App\Legacy\LegacyDB::delete('advices WHERE userID = ?', $studentId);
	} else if (\App\Legacy\LegacyDB::exists('advices WHERE userID = ?', $studentId)) {
		\App\Legacy\LegacyDB::update('advices SET advices = ? WHERE userID = ?', [$advices, $studentId]);
	} else {
		\App\Legacy\LegacyDB::add('advices (userID, advices) VALUES (?, ?)', [$studentId, $advices]);
	}

	redirect_old();
}
