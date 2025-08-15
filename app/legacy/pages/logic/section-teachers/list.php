<?php

/**
 * Page configuration
 */

use LogicManager\AdminLogic;
use \Legacy\UserSystem\Teacher;

$pageConfig['add'] = false;
// $pageConfig['row-action'] = 'add?id={{id}}';

/**
 * Query configuration
 */
$queryConfig['table'] = 'teachers';
$queryConfig['index'] = 'userId';
$queryConfig['select'] = ['userId', 'username', 'email', 'first_name', 'last_name', 'time'];

$queryConfig['from'] = 'teachers
INNER JOIN users
ON teachers.userId = users.id';

$queryConfig['where-search'] = "
userId IN (SELECT id FROM users WHERE
	first_name LIKE CONCAT('%',?,'%') OR
	last_name LIKE CONCAT('%',?,'%') OR
	email LIKE CONCAT('%',?,'%') OR
	CONCAT(first_name, ' ', last_name) LIKE CONCAT('%',?,'%') OR
	CONCAT(last_name, ' ', first_name) LIKE CONCAT('%',?,'%')
) OR
FIND_IN_SET (?, classes)";

// select fields
$fields = [
	['title' => 'ID', 'name' => 'userId',],
	['title' => 'Username', 'name' => 'username'],
	['title' => 'Nome', 'name' => 'first_name', 'size' => 2,],
	['title' => 'Cognome', 'name' => 'last_name', 'size' => 2,],
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

Admin\App\Legacy\Logic::$listResultConfiguration = function ($entry, $key, $field, $queryRow) {
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
