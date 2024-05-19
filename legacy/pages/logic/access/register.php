<?php

global $view;

// style
$view->styles->add('login', 'page');

// setup variables
$error = false;

// setup form
$inputs = [
	/*[
		['type' => 'lbl', 'text' => __('Username')],
		['name' => 'username', 'text' => __('Username'), 'maxlength' => 20, 'required' => true,],
		['type' => 'error', 'error' => 'user-match', 'text' => __('The chosen username already exists'),],
	],*/
	[
		['type' => 'lbl', 'text' => 'E-mail'],
		['type' => 'email', 'text' => 'Indirizzo e-mail', 'name' => 'email', 'maxlength' => 50, 'required' => true,],
		['type' => 'error', 'error' => 'mail-match', 'text' => __('Email address already associated with another account'),],
	],
	[
		['type' => 'lbl', 'text' => __('Password'),],
		['type' => 'password', 'text' => __('Password'), 'name' => 'password', 'maxlength' => 20, 'required' => true,],
		['type' => 'error', 'error' => 'password-short', 'text' => __('The chosen password is too short'),],
		['type' => 'password', 'text' => __('Confirm password'), 'name' => 'password-confirmation', 'maxlength' => 20, 'required' => true,],
		['type' => 'error', 'error' => 'password-match', 'text' => __('The chosen passwords do not match'),],
	],
	/*[
		['type' => 'cbx', 'text' => 'Ho letto e acconsento al <a href="'.__CLIENT_ROOT__.'/infos/privacy">trattamento dei dati</a>', 'required' => true,],
	],*/
];

// submit
if (isset($_POST['submit'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConfirmation = $_POST['password-confirmation'];

	// check for errors
	if (\App\Legacy\LegacyDB::exists('users WHERE email=?', [$email])) $error = 'mail-match';
	//else if (\App\Legacy\LegacyDB::exists('users WHERE username=?', [$_POST['username']])) $error = 'user-match';
	else if (strlen($password) < 6) $error = 'password-short';
	else if ($password != $passwordConfirmation) $error = 'password-match';
	else {
		// add user
		//$id = \App\Legacy\LegacyDB::add('users (username, password, mail) VALUES (?, MD5(?), ?)', [$_POST['username'], $password, $_POST['mail']]);
		$id = \App\Legacy\LegacyDB::add('users (password, email) VALUES (MD5(?), ?)', [$password, $email]);

		login($email, $password);
	}
}
