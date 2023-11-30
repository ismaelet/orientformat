<?php

use Activity\Result\Handler\StudentTestResult;
use UserSystem\Student;

$studentId = $_GET['studentId'] ?? null;
$student = new Student($studentId);
$profile = $student->profile;
$choice = $profile->dynamicChoice();

$motivationArea = (new StudentTestResult(20, $studentId))->result ?: '<span class="fw-semibold">Non ancora completata</span>';
$interestArea = (new StudentTestResult(92, $studentId))->result ?: '<span class="fw-semibold">Non ancora completata</span>';


// fetch advices
$advices = [];
$advicesRes = DB::select('id, advice FROM advices_list ORDER BY id ASC');

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
		DB::delete('advices WHERE userID = ?', $studentId);
	} else if (DB::exists('advices WHERE userID = ?', $studentId)) {
		DB::update('advices SET advices = ? WHERE userID = ?', [$advices, $studentId]);
	} else {
		DB::add('advices (userID, advices) VALUES (?, ?)', [$studentId, $advices]);
	}

	redirect();
}
