<?php

/**
 * Page configuration
 */

use LogicManager\AdminLogic;
use SchoolSystem\School;
use SchoolSystem\SchoolClass;
use UserSystem\Student;

$pageConfig['add'] = false;
// $pageConfig['row-action'] = 'add?id={{id}}';

/**
 * Query configuration
 */
$queryConfig['table'] = Student::TABLE;
$queryConfig['index'] = Student::INDEX;
$queryConfig['select'] = [Student::INDEX, Student::SCHOOL_CLASS_INDEX, 'username', 'email', 'firstName', 'lastName', 'users.time', 'schools.name as schoolName'];
$queryConfig['from'] = '
	students
	INNER JOIN users
	ON students.userId = users.id
	INNER JOIN ' . SchoolClass::TABLE . '
	ON students.' . Student::SCHOOL_CLASS_INDEX . ' = ' . SchoolClass::TABLE . '.id
	INNER JOIN ' . School::TABLE . '
	ON ' . SchoolClass::TABLE . '.' . SchoolClass::SCHOOL_INDEX . ' = ' . School::TABLE . '.id';

$queryConfig['where-search'] = "
	userId = ? OR
	" . Student::SCHOOL_CLASS_INDEX . " = ? OR
	firstName LIKE CONCAT('%',?,'%') OR
	lastName LIKE CONCAT('%',?,'%') OR
	CONCAT(firstName, ' ', lastName) LIKE CONCAT('%',?,'%') OR
	CONCAT(lastName, ' ', firstName) LIKE CONCAT('%',?,'%') OR
	email LIKE CONCAT('%',?,'%')
";

// select fields
$fields = [
	['title' => 'ID', 'name' => 'userId'],
	['title' => 'Username', 'name' => 'username', 'size' => 2],
	['title' => 'Nome', 'name' => 'firstName'],
	['title' => 'Cognome', 'name' => 'lastName'],
	['title' => 'Classe', 'name' => 'schoolClassName'],
	['title' => 'Istituto', 'name' => 'schoolName', 'size' => 2],
	['title' => 'Anno scolastico', 'name' => 'year'],
	['title' => 'Email', 'name' => 'email', 'size' => 3],
	['title' => 'Registrato', 'name' => 'time', 'parse' => 'date-day',],
];

$buttons = [];

if (manager()) {
	$fields[] = ['type' => 'btn'];
	$buttons[] = ['title' => 'Login', 'name' => 'login', 'color' => 'green'];
}

// login as an user
if (isset($_POST['login'])) {
	$_SESSION['userId'] = $_POST['login'];

	header('Location: ' . PUBLIC_CLIENT_ROOT . '/');
}

Admin\App\Legacy\Logic::$listResultConfiguration = function ($entry, $key, $field, $queryRow) {
	$student = new Student($queryRow[Student::INDEX]);
	$schoolClass = new SchoolClass($queryRow[Student::SCHOOL_CLASS_INDEX]);

	if ($field['name'] == 'schoolClassName') {
		$entry['value'] = $schoolClass->name . ' (' . $schoolClass->id . ')';
	} else if ($field['name'] == 'year') {
		$entry['value'] = $schoolClass->yearRangeString;
	} else if ($field['name'] == 'school') {
		$entry['value'] = $schoolClass->school->name;
	}

	return $entry;
};
