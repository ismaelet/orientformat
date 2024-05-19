<?php

use \Legacy\Activity\Section;
use \Legacy\Activity\Test;

// grade selection and activities
\Legacy\System\Classes\LegacyRoute::add('/activities', function () {
	$grade = $_GET['grade'] ?? null;
	$page = in_array($grade, [1, 2, 3, 4, 5, 6, 7, 8]) ? 'activities/list' : 'activities/grades';

	add_grade_style();

	\Legacy\System\Classes\LegacyView::setPage($page)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// tests
\Legacy\System\Classes\LegacyRoute::add(['/profile/section', '/skills/section', '/knowledge/section', '/choose/section'], function () {
	// get test and section
	$sectionId = $_GET['id'] ?? null;
	$testId = $_GET['test-id'] ?? null;
	$section = new Section($sectionId);
	$supervisorView = false;

	if (!$section->id) {
		redirect_old('/');
	}

	// add the style
	add_grade_style();

	if (!$section->isStandard) {
		$testId = \Legacy\System\Classes\LegacyDB::find(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ?', [$section->id]);
	} else if (!$testId && !$section->completed) {
		$testId = $section->checkpointId;
	}

	// page data
	if ($testId) {
		if (!isset($_GET['test-id'])) redirect_old($section->url . '&test-id=' . $testId);
		$test = new Test($testId);
		$page = $test->filePath;
		$template = $test->template;
		$title = $test->title;
	} else {
		$page = $section->filePath . '/recap';
		$template = 'recap';
		$title = 'Riepilogo ' . $section->name;
	}

	// render
	\Legacy\System\Classes\LegacyView::setPage($page)
		->setTemplate($template)
		->setTitle($title)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->set('section', $section)
		->set('test', $test ?? null)
		->set('supervisorView', $supervisorView)
		->show();
});


// interests
\Legacy\System\Classes\LegacyRoute::add('/interest', function () {
	add_grade_style();

	\Legacy\System\Classes\LegacyView::setPage('interest')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// review
\Legacy\System\Classes\LegacyRoute::add('/review', function () {
	\Legacy\System\Classes\LegacyView::setPage('review')
		->setMiddlewares(['public', 'student', 'logged', 'active', 'required-email'])
		->show();
});
