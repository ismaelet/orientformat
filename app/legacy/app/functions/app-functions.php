<?php

use \Legacy\SchoolSystem\SchoolClass;
use \Legacy\UserSystem\ActiveStudent;
use \Legacy\UserSystem\ActiveTeacher;
use \Legacy\UserSystem\Student;

/**
 * Student & teachers
 */
function teacherId() {
	return teacher()->id;
}

function isStudent() {
	return (bool) !is_teacher();
}

function watchedStudentId() {
	return request()->student_id ?? \Illuminate\Support\Facades\Auth::id();
}

function watchedStudent() {
	if (isSupervisor() && (!is_teacher_or_administrator() || (is_teacher() && !in_array(watchedStudentId(), teacher()->studentIds)) || (is_administrator() && !in_array(watchedStudentId(), administrator()->studentIds())))) {
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
	}

	if (is_teacher_or_administrator()) {
		return 'highschool';
	}

	if (is_student()) {
		return student()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}
}

function add_grade_style() {
	$style = get_grade_style();

	if ($style) {
		\App\Legacy\StyleLoader::add('specific-styles/' . get_grade_style(), 'app', 5);
	}
}

/**
 * Misc
 */
function printConnectionTime() {
}

function printQueriesCount() {
}
