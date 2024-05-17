<?php

namespace Legacy\SchoolSystem;

class School {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'schools';
	public const INDEX = 'id';

	/**
	 * Get methods
	 */
	private function getName() {
		return ucwords(strtolower($this->databaseEntry['name']));
	}
}
