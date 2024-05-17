<?php

use \Legacy\Activity\Section;
use \Legacy\Activity\Test;

// grade selection and activities
RouteOld::add('/activities', function () {
	$grade = $_GET['grade'] ?? null;
	$page = in_array($grade, [1, 2, 3, 4, 5, 6, 7, 8]) ? 'activities/list' : 'activities/grades';

	add_grade_style();

	ViewOld::setPage($page)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// tests
RouteOld::add(['/profile/section', '/skills/section', '/knowledge/section', '/choose/section'], function () {
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
		$testId = \System\Classes\DBOld::find(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ?', [$section->id]);
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
	ViewOld::setPage($page)
		->setTemplate($template)
		->setTitle($title)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->set('section', $section)
		->set('test', $test ?? null)
		->set('supervisorView', $supervisorView)
		->show();
});

// areas
RouteOld::add('/student-read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area'] ?? null;

	if ($id) {
		$section = \System\Classes\DBOld::find('slug FROM ' . Section::TABLE . ' WHERE id = ?', $id);
	}

	if ($areaId) {
		$area = \System\Classes\DBOld::find('slug FROM areas WHERE id = ?', $areaId);
	}

	$page = $id ? $section : 'area-' . $area;

	if (!$page) {
		redirect_old('/');
	}

	add_grade_style();

	ViewOld::setPage('student-read/' . $page)
		->setTitle('Saperne di più')
		->setTemplate('student-read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->set('sectionId', $id)
		->set('areaId', $areaId)
		->show();
});

// interests
RouteOld::add('/interest', function () {
	add_grade_style();

	ViewOld::setPage('interest')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// review
RouteOld::add('/review', function () {
	ViewOld::setPage('review')
		->setMiddlewares(['public', 'student', 'logged', 'active', 'required-email'])
		->show();
});
