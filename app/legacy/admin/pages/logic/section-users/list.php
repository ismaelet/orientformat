<?php

/**
 * Page configuration
 */
// $pageConfig['add'] = false;
$pageConfig['row-action'] = 'add?id={{id}}';

/**
 * Query configuration
 */
$queryConfig['table'] = 'users';
$queryConfig['index'] = 'id';
$queryConfig['where-search'] = "id = ? OR first_name LIKE CONCAT('%',?,'%') OR last_name LIKE CONCAT('%',?,'%') OR email LIKE CONCAT('%',?,'%')";

// fields
$fields = [
	['title' => 'ID', 'name' => 'id', 'size' => 1],
	//['title' => 'Username', 'name' => 'username', 'size' => 3],
	['title' => 'Username / E-mail', 'name' => 'email', 'size' => 4],
	['title' => 'Nome', 'name' => 'first_name', 'size' => 3],
	['title' => 'Cognome', 'name' => 'last_name', 'size' => 3],
	//['title' => 'Email', 'name' => 'email', 'size' => 3],
	['title' => 'Tipologia', 'name' => 'groupId', 'type' => 'find', 'find' => 'name FROM user_groups WHERE id = ?', 'size' => 2],
	['type' => 'btn'],
];

$buttons = [
	['type' => 'edit'],
	['type' => 'delete'],
];

if (manager()) {
	$buttons[] = ['title' => 'Login', 'name' => 'login', 'color' => 'green'];
}

// login as an user
if (isset($_POST['login'])) {
	$_SESSION['userId'] = $_POST['id'];

	redirect(PUBLIC_CLIENT_URL . '/profile');
}
