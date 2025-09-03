<?php

use App\Helpers\ArrayHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use \Legacy\Activity\Section as LegacySection;
use \Legacy\Activity\Test as LegacyTest;

// tests
\App\Legacy\LegacyRoute::add(['/profile/section', '/skills/section', '/knowledge/section', '/choose/section'], function () {
	// get test and section
	$sectionId = request()->id;
	$testId = request()->test_id;
	$studentId = request()->student_id;
	$legacySection = new LegacySection($sectionId);

	add_grade_style();

	if (!$legacySection->id) {
		redirect_old('/');
	}

	if (!$legacySection->isStandard) {
		$testId = \App\Legacy\LegacyDB::find(LegacyTest::INDEX . ' FROM ' . LegacyTest::TABLE . ' WHERE ' . LegacyTest::SECTION_INDEX . ' = ?', [$legacySection->id]);
	} else if (!$testId && !$legacySection->completed) {
		$testId = $legacySection->checkpointId;
	}

	// page data
	if ($testId) {
		$test = Test::find($testId);
		redirect_old($test->url($studentId));
	} else {
		$section = Section::find($sectionId);
		redirect_old($section->url());
	}
});

\App\Legacy\LegacyRoute::add('/activities/tests/*', function ($path) {
	$testId = ArrayHelper::explodeLast('/', $path)[1];
	$legacyTest = new LegacyTest($testId);
	$page = $legacyTest->filePath;
	$template = $legacyTest->template;
	$title = $legacyTest->title;


	add_grade_style();

	// render
	\App\Legacy\LegacyView::setPage($page)
		->setTemplate($template)
		->setTitle($title)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'required-email'])
		->set('section', $legacyTest->section)
		->set('test', $legacyTest ?? null)
		->show();
});

// interests
\App\Legacy\LegacyRoute::add('/interest', function () {


	add_grade_style();

	\App\Legacy\LegacyView::setPage('interest')
		->show();
});

// review
\App\Legacy\LegacyRoute::add('/review', function () {

	add_grade_style();

	\App\Legacy\LegacyView::setPage('review')
		->setMiddlewares(['public', 'student', 'logged', 'active', 'required-email'])
		->show();
});
