<?php

$userId = $_GET['id'];
$error = false;
$done = false;

if (isset($_POST['submit'])) {
	$password = $_POST['password'];
	$passwordConfirmation = $_POST['password-confirmation'];

	if ($password != $passwordConfirmation) $error = 'no-match';
	else {
		DB::delete('user_resets WHERE userId = ?', [$userId]);
		DB::update('users SET password = ? WHERE id = ?', [$password, $userId]);

		$done = true;
	}
}
