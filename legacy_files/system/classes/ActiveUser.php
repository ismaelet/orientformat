<?php

namespace System\Classes;

use User;

class ActiveUser {

	use \System\Traits\Singleton;

	private static $id;
	private static $user;

	/**
	 * Magic methods
	 */
	private function __construct() {
		$userId = null;

		if (\System\Classes\ConfigOld::getInstance()->hasDatabase) {
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
		self::$id = $id;
		self::$user = new User($id);

		return $this;
	}
}
