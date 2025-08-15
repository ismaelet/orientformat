<?php

use App\Models\Activities\Area;
use App\Models\Activities\Section;
use \Legacy\Activity\Test;

$legacySection = \App\Legacy\LegacyView::getInstance()->get('section');
$legacyArea = $legacySection->area;
$section = Section::find($legacySection->id);
$area = Area::find($legacyArea->id);

if (is_teacher_or_administrator()) {
	$backUrl = client_url('/teacher/simulation');
} else {
	$gradeNumber = session()->get('activities-year') ?? student()->schoolClass->relativeGrade;
	$backUrl = route('activities.grades.show', $gradeNumber);
}

// get tests
$legacyTests = [];
$res = \App\Legacy\LegacyDB::select('id FROM ' . Test::TABLE . ' WHERE sectionID = ? AND active = 1 AND template <> "recap" ORDER BY step ASC', [$legacySection->id]);

while ($row = $res->fetch_assoc()) {

	$legacyTestM = new Test($row['id']);

	if ($legacyTestM->completed) $desc = $legacyTestM->percentage == 100 || $legacyTestM->template == 'survey' || $legacySection->id == 8 ? __("Already completed") : __('Result') . ': <strong>' . $legacyTestM->percentage . '%</strong>';
	else $desc = __('Not completed');

	$legacyTest_arr = [
		'obj' => $legacyTestM,
		'desc' => $desc,
		'img' => 'tests/' . $legacySection->mainSection->slug . '/recap/' . $legacyTestM->slug,
	];

	$legacyTests[] = $legacyTest_arr;
}

$coverImage = file_exists(server_path($file = '/pages/assets/' . $legacySection->mainSection->filePath . '/recap/background.webp')) ? $file : str_replace('background.webp', 'bgr.png', $file);

// reset a section
if (isset($_POST['reset'])) {
	(new Test($_POST['testId']))->redo();
}

// download survey results
if (isset($_POST['download'])) {
	$legacyTest = new Test($_POST['testId']);

	if ($legacyTest->completed) {
		print_survey_results($legacyTest->id, userId());
	}
}
