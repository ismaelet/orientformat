<?php

namespace Student;

use DatabaseObject;
use DBOld;

class Profile {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'students_data';
	public const INDEX = 'studentId';

	/**
	 * Get methods
	 */

	/**
	 * Istance methods
	 */
	public static function new(int $id) {
		\System\Classes\DBOld::add(self::TABLE . ' (' . self::INDEX . ')', [$id]);

		return new self($id);
	}
}
