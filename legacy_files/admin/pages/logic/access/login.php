<?php

$action = $_GET['action'] ?? null;
$error = false;

// structure
$loginConfig = [
	'welcome-text' => true,
	'stay-connected' => true,
	'password-recovery' => true,
	'register' => true,
];

// login
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$remember = isset($_POST['remember']);
	$url = $_POST['url'] ?? false;

	if (DB::exists(User::TABLE . ' WHERE (username = ? OR email = ?) AND admin > 0', [$username, $username])) {
		$error = standard_login($username, $password, $url, $remember);
	} else {
		$error = 'no-user';
	}
}
