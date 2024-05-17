<?php

$userId = $_GET['id'];
$error = false;
$done = false;

if (isset($_POST['submit'])) {
	$password = $_POST['password'];
	$passwordConfirmation = $_POST['password-confirmation'];

	if ($password != $passwordConfirmation) $error = 'no-match';
	else {
		\System\Classes\DBOld::delete('user_resets WHERE userId = ?', [$userId]);
		\System\Classes\DBOld::update('users SET password = ? WHERE id = ?', [$password, $userId]);

		$done = true;
	}
}
