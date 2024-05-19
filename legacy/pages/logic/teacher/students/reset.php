<?php

//setup variables
$id = $_GET['id'] ?? false;
$valid = false;

if (isset($_SESSION['password_reset'])) {

	unset($_SESSION['password_reset']);
	$valid = true;
}

if (!$valid || !\Legacy\System\Classes\LegacyDB::exists('users WHERE id = ? AND level=0', [$id])) redirect_old('/teacher/students');

//generate new password
$password = bin2hex(random_bytes(5));

$db_password = password_hash($password, PASSWORD_DEFAULT);

\Legacy\System\Classes\LegacyDB::update('users SET password = ? WHERE id = ?', [$db_password, $id]);

//store variables
$this->set('password', $password);
