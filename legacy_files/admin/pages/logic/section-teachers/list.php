<?php

/**
 * Page configuration
 */

use LogicManager\AdminLogic;
use UserSystem\Teacher;

$pageConfig['add'] = false;
// $pageConfig['row-action'] = 'add?id={{id}}';

/**
 * Query configuration
 */
$queryConfig['table'] = 'teachers';
$queryConfig['index'] = 'userId';
$queryConfig['select'] = ['userId', 'username', 'email', 'firstName', 'lastName', 'time'];

$queryConfig['from'] = 'teachers
INNER JOIN users
ON teachers.userId = users.id';

$queryConfig['where-search'] = "
userId IN (SELECT id FROM users WHERE
	firstName LIKE CONCAT('%',?,'%') OR
	lastName LIKE CONCAT('%',?,'%') OR
	email LIKE CONCAT('%',?,'%') OR
	CONCAT(firstName, ' ', lastName) LIKE CONCAT('%',?,'%') OR
	CONCAT(lastName, ' ', firstName) LIKE CONCAT('%',?,'%')
) OR
FIND_IN_SET (?, classes)";

// select fields
$fields = [
	['title' => 'ID', 'name' => 'userId',],
	['title' => 'Username', 'name' => 'username'],
	['title' => 'Nome', 'name' => 'firstName', 'size' => 2,],
	['title' => 'Cognome', 'name' => 'lastName', 'size' => 2,],
	['title' => 'Email', 'name' => 'email'],
	['title' => 'Registrato', 'name' => 'time', 'parse' => 'time-day',],
	['title' => 'Classi', 'name' => 'schoolClasses', 'size' => 4, 'not-sortable' => true],
];

if (manager()) {
	$fields[] = ['type' => 'btn'];

	$buttons = [
		['title' => 'Login', 'name' => 'login', 'color' => 'green'],
	];
}

// login as an user
if (isset($_POST['login'])) {
	$_SESSION['userId'] = $_POST['login'];

	header('Location: ' . PUBLIC_CLIENT_ROOT . '/');
}

AdminLogic::$listResultConfiguration = function ($entry, $key, $field, $queryRow) {
	if ($field['name'] == 'schoolClasses') {
		$schoolClassString = [];
		$teacher = new Teacher($queryRow['userId']);

		if ($teacher->schoolClasses) {
			foreach ($teacher->schoolClasses as $schoolClass) {
				$schoolClassString[] = '<strong>' . $schoolClass->id . '</strong>: ' . $schoolClass->fullName;
			}

			if (!empty($schoolClassString)) {
				$entry['value'] = implode('<br>', $schoolClassString);
			}
		}
	}

	return $entry;
};
