<?php

namespace App\Legacy;

/**
 * User class
 * 
 * @property string fullName
 * @property string invertedFullName
 * @property bool isAdmin
 * @property bool isManager
 */
class User {

	use DatabaseObject;

	public const TABLE = 'users';
	public const INDEX = 'id';
	public const GROUP_INDEX = 'groupId';

	/**
	 * Get methods
	 */
	private function getFullName() {
		$fullName = [];

		if ($this->first_name) {
			$fullName[] = $this->first_name;
		}

		if ($this->last_name) {
			$fullName[] = $this->last_name;
		}

		return implode(' ', $fullName);
	}

	private function getInvertedFullName() {
		$fullName = [];

		if ($this->last_name) {
			$fullName[] = $this->last_name;
		}

		if ($this->first_name) {
			$fullName[] = $this->first_name;
		}

		return implode(' ', $fullName);
	}

	private function getIsAdmin() {
		return (bool) $this->admin;
	}

	private function getIsManager() {
		return $this->admin == 2;
	}

	private function getEmailIsUsername() {
		return !$this->username || $this->username == $this->email;
	}
}
