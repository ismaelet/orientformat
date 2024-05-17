<?php

use \Legacy\Activity\Test;

$section = ViewOld::getInstance()->get('section');
$area = $section->area;

if (isTeacher()) {
	$backUrl = '/teacher/simulation';
} else {
	$gradeNumber = $_SESSION['activities-year'] ?? student()->schoolClass->relativeGrade;
	$backUrl = '/activities?grade=' . $gradeNumber;
}

// get tests
$tests = [];
$res = \System\Classes\DBOld::select('id FROM ' . Test::TABLE . ' WHERE sectionID = ? AND active = 1 AND template <> "recap" ORDER BY step ASC', [$section->id]);

while ($row = $res->fetch_assoc()) {

	$testM = new Test($row['id']);

	if ($testM->completed) $desc = $testM->percentage == 100 || $testM->template == 'survey' || $section->id == 8 ? 'Già completata' : 'Risultato: <strong>' . $testM->percentage . '%</strong>';
	else $desc = 'Non completata';

	$test_arr = [
		'obj' => $testM,
		'desc' => $desc,
		'img' => '/pages/assets/' . $section->mainSection->filePath . '/recap/' . $testM->slug,
	];

	$tests[] = $test_arr;
}

$coverImage = file_exists(server_path($file = '/pages/assets/' . $section->mainSection->filePath . '/recap/background.webp')) ? $file : str_replace('background.webp', 'bgr.png', $file);

// reset a section
if (isset($_POST['reset'])) {
	(new Test($_POST['testId']))->redo();
}

// download survey results
if (isset($_POST['download'])) {
	$test = new Test($_POST['testId']);

	if ($test->completed) {
		print_survey_results($test->id, userId());
	}
}
