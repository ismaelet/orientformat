<?php

use SchoolSystem\SchoolClass;
use UserSystem\ActiveStudent;
use UserSystem\ActiveTeacher;
use UserSystem\Student;

/**
 * Student & teachers
 */
function student() {
	return isTeacher() ? teacher() : ActiveStudent::getInstance();
}

function studentId() {
	return student()->id;
}

function teacher() {
	return ActiveTeacher::getInstance();
}

function teacherId() {
	return teacher()->id;
}

function isTeacher() {
	return (bool) teacherId();
}

function isStudent() {
	return (bool) !isTeacher();
}

function watchedStudentId() {
	return $_GET['studentId'] ?? studentId();
}

function watchedStudent() {
	if (isSupervisor() && (!isTeacher() || !in_array(watchedStudentId(), teacher()->studentIds))) {
		return student();
	} else {
		return new Student(watchedStudentId());
	}
}

function isSupervisor() {
	return watchedStudentId() != studentId();
}

/**
 * Tests
 */
function test() {
	return View::get('test');
}

function testId() {
	return test()->id;
}

/**
 * School class
 */
function schoolClass() {
	return new SchoolClass($_SESSION['dashboard-schoolClassId']);
}

function schoolClassId() {
	return schoolClass()->id;
}

/**
 * Grades
 */
function realGradeId($oldGradeId) {
	switch (true) {
		case strpos($oldGradeId, 'P'):
			return $oldGradeId[0] + 3;

		case strpos($oldGradeId, 'L'):
			return $oldGradeId[0];

		default:
			return $oldGradeId;
	}
}

/**
 * Misc
 */
function sysDashboardGraphsConfig($field) {
	include(SERVER_ROOT . '/app/config/dashboard-graphs.php');
	return $configDashboardGraphs[$field] ?? false;
}

function section_config($sectionId, $field) {
	global $sectionsConfig;

	include_once(SERVER_ROOT . '/app/config/sections.php');

	if (isset($sectionsConfig[$sectionId][$field])) {
		$value = $sectionsConfig[$sectionId][$field];
	} else {
		switch ($field) {
			case 'tiers':
				$value = ['Molto basso', 'Basso', 'Normale', 'Alto', 'Molto alto'];
				break;
			default:
				$value = false;
				break;
		}
	}

	return $value;
}

function test_config($testId, $field) {
	global $testsConfig;

	include_once(SERVER_ROOT . '/app/config/tests.php');

	return $testsConfig[$testId][$field] ?? false;
}

function profile_config($type) {
	global $surveyStartQuestions, $surveyEndQuestions;

	include_once(SERVER_ROOT . '/app/config/surveys.php');

	$questions = $type == 'start' ? $surveyStartQuestions : $surveyEndQuestions;

	return $questions;
}

/**
 * Style
 */
function get_grade_style() {
	if (isSupervisor()) {
		return watchedStudent()->isInMiddleSchool ? 'middleschool' : 'highschool';
	} else if (isTeacher()) {
		return 'highschool';
	} else {
		return student()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}
}

function add_grade_style() {
	StyleLoader::add('specific-styles/' . get_grade_style(), 'app', 5);
}

if (!function_exists("array_is_list")) {
	function array_is_list(array $array): bool {
		$i = 0;
		foreach ($array as $k => $v) {
			if ($k !== $i++) {
				return false;
			}
		}
		return true;
	}
}

/**
 * Misc
 */
function printConnectionTime() {
	if (DEBUG) {
		echo 'Connection time: ' . round(microtime(true) - ConnectionInterface::$timeOpen, 3) * 1000 . ' ms<br>';
	}
}

function printQueriesCount() {
	if (DEBUG) {
		echo 'Queries count: ' . ConnectionInterface::$queryCount . '<br>';
	}
}
