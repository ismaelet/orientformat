<?php

class ActiveUser {

	use Singleton;

	private static $id;
	private static $user;

	/**
	 * Magic methods
	 */
	private function __construct() {
		$userId = null;

		if (Config::getInstance()->hasDatabase) {
			$userId = $_SESSION['userId'] ?? $userId;
			$userToken = $_COOKIE['auth_token'] ?? null;

			if (!$userId && $userToken) {
				$userId = token_login($userToken);
			}
		}

		self::$id = $userId;
		self::$user = new User($userId);
	}

	function __get($property) {
		return self::$user->$property;
	}

	/**
	 * Set methods
	 */
	public function setId(int $id) {
		$_SESSION['userId'] = $id;

		self::$id = $id;
		self::$user = new User($id);

		return $this;
	}
}
