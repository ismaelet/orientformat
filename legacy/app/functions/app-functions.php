<?php

use \Legacy\SchoolSystem\SchoolClass;
use \Legacy\UserSystem\ActiveStudent;
use \Legacy\UserSystem\ActiveTeacher;
use \Legacy\UserSystem\Student;

/**
 * Student & teachers
 */
function student() {
	return is_teacher() ? teacher() : ActiveStudent::getInstance();
}

function teacher() {
	return ActiveTeacher::getInstance();
}

function teacherId() {
	return teacher()->id;
}

function isStudent() {
	return (bool) !is_teacher();
}

function watchedStudentId() {
	return $_GET['studentId'] ?? \Illuminate\Support\Facades\Auth::id();
}

function watchedStudent() {
	if (isSupervisor() && (!is_teacher() || !in_array(watchedStudentId(), teacher()->studentIds))) {
		return student();
	} else {
		return new Student(watchedStudentId());
	}
}

function isSupervisor() {
	return watchedStudentId() != \Illuminate\Support\Facades\Auth::id();
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
	} else if (is_teacher()) {
		return 'highschool';
	} else {
		return student()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}
}

function add_grade_style() {
	\Legacy\System\Classes\StyleLoader::add('specific-styles/' . get_grade_style(), 'app', 5);
}

/**
 * Misc
 */
function printConnectionTime() {
	if (DEBUG) {
		echo 'Connection time: ' . round(microtime(true) - \Legacy\System\Classes\ConnectionInterface::$timeOpen, 3) * 1000 . ' ms<br>';
	}
}

function printQueriesCount() {
	if (DEBUG) {
		echo 'Queries count: ' . \Legacy\System\Classes\ConnectionInterface::$queryCount . '<br>';
	}
}
