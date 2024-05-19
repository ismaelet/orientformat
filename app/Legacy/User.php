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

		if ($this->firstName) {
			$fullName[] = $this->firstName;
		}

		if ($this->lastName) {
			$fullName[] = $this->lastName;
		}

		return implode(' ', $fullName);
	}

	private function getInvertedFullName() {
		$fullName = [];

		if ($this->lastName) {
			$fullName[] = $this->lastName;
		}

		if ($this->firstName) {
			$fullName[] = $this->firstName;
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
