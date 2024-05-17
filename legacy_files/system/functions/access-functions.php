<?php

function login(int $userId, bool $remember = true) {
	// remove old accesses
	// \System\Classes\DBOld::delete('auth_tokens WHERE expiration < NOW() AND userID = ?', [$userId]);

	// remember me
	/*
	if ($remember) {
		$selector = bin2hex(random_bytes(6));
		$validator = bin2hex(random_bytes(12));
		$validatorHash = hash('sha256', $validator);

		\System\Classes\DBOld::add('auth_tokens (selector, validator, userID, expiration) VALUES (?, ?, ?, (NOW() + INTERVAL 1 MONTH))', [$selector, $validatorHash, $userId]);

		setcookie('auth_token', $selector . '_' . $validator, time() + 60 * 60 * 24 * 30);
	}*/

	// login
	\System\Classes\ActiveUser::getInstance()->setId($userId);

	if (isset($_SESSION['login-attempts'])) {
		unset($_SESSION['login-attempts']);
	}

	return $userId;
}

/**
 * Login with username/email and password
 */
function standard_login(string $username, string $password, string $url = null, bool $remember = true) {
	$username = strtolower($username);

	// set redirect location
	$url = $url ?: \System\Classes\ConfigOld::getInstance()->loggedRedirectUrl;

	// fetch user data
	$userData = \System\Classes\DBOld::row('id, password FROM users WHERE (lower(username) = ? OR lower(email) = ?)', [$username, $username]);

	if ($userData) {
		// successful login
		$userId = $userData['id'];
		$dbPassword = $userData['password'];

		// update old password
		if ($dbPassword[0] != '$' && ($password == $dbPassword || md5($password) == $dbPassword)) {
			$dbPassword = password_hash($password, PASSWORD_DEFAULT);

			\System\Classes\DBOld::update('users SET password = ? WHERE id = ?', [$dbPassword, $userId]);
		}

		if (password_verify($password, $dbPassword)) {
			// successful login
			login($userId, $remember);
		} else {
			// wrong password
			return 'error-wrong-data';
		}

		redirect_old($url);
	} else {
		// unsuccessful login
		if (isset($_SESSION['login-attempts'])) {
			$_SESSION['login-attempts']++;
		} else {
			$_SESSION['login-attempts'] = 1;
		}

		return 'error-wrong-data';
	}
}

// direct login
function token_login(string $token) {
	$userId = null;
	$validToken = false;
	$token = explode('_', $token);
	$selector = $token[0];
	/*$userData = \System\Classes\DBOld::row('userId, validator FROM auth_tokens WHERE selector=? AND expiration>NOW()', [$selector]);

	if (isset($token[1]) && $userData) {
		$validator = $token[1];
		$validatorHash = hash('sha256', $validator);

		if (hash_equals($validatorHash, $userData['validator'])) {
			$userId = $userData['userId'];
			login($userId);
		}
	}*/

	if (!$validToken) {
		setcookie('auth_token', '', -1, '/');
	}

	return $userId;
}

function logout(string $url = '/') {
	// setcookie('auth_token', '', -1);

	// \System\Classes\DBOld::delete('auth_tokens WHERE userID = ?', userId());

	session_destroy();

	redirect_old($url);
}
