<?php

use Activity\Section;
use Activity\Test;

// grade selection and activities
Route::add('/activities', function () {
	$grade = $_GET['grade'] ?? null;
	$page = in_array($grade, [1, 2, 3, 4, 5, 6, 7, 8]) ? 'activities/list' : 'activities/grades';

	add_grade_style();

	View::setPage($page)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// tests
Route::add(['/profile/section', '/skills/section', '/knowledge/section', '/choose/section'], function () {
	// get test and section
	$sectionId = $_GET['id'] ?? null;
	$testId = $_GET['test-id'] ?? null;
	$section = new Section($sectionId);
	$supervisorView = false;

	if (!$section->id) {
		redirect('/');
	}

	// add the style
	add_grade_style();

	if (!$section->isStandard) {
		$testId = DB::find(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ?', [$section->id]);
	} else if (!$testId && !$section->completed) {
		$testId = $section->checkpointId;
	}

	// page data
	if ($testId) {
		if (!isset($_GET['test-id'])) redirect($section->url . '&test-id=' . $testId);
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
	View::setPage($page)
		->setTemplate($template)
		->setTitle($title)
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->set('section', $section)
		->set('test', $test ?? null)
		->set('supervisorView', $supervisorView)
		->show();
});

// areas
Route::add('/student-read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area'] ?? null;

	if ($id) {
		$section = DB::find('slug FROM ' . Section::TABLE . ' WHERE id = ?', $id);
	}

	if ($areaId) {
		$area = DB::find('slug FROM areas WHERE id = ?', $areaId);
	}

	$page = $id ? $section : 'area-' . $area;

	if (!$page) {
		redirect('/');
	}

	add_grade_style();

	View::setPage('student-read/' . $page)
		->setTitle('Saperne di più')
		->setTemplate('student-read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->set('sectionId', $id)
		->set('areaId', $areaId)
		->show();
});

// interests
Route::add('/interest', function () {
	add_grade_style();

	View::setPage('interest')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'])
		->show();
});

// review
Route::add('/review', function () {
	View::setPage('review')
		->setMiddlewares(['public', 'student', 'logged', 'active', 'required-email'])
		->show();
});
