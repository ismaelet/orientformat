<?php

namespace Student;

use DatabaseObject;
use DB;

class Profile {

	use DatabaseObject;

	public const TABLE = 'students_data';
	public const INDEX = 'studentId';

	/**
	 * Get methods
	 */

	/**
	 * Istance methods
	 */
	public static function new(int $id) {
		DB::add(self::TABLE . ' (' . self::INDEX . ')', [$id]);

		return new self($id);
	}
}
