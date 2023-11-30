<?php

namespace UserSystem;

use DB;
use Singleton;

class ActiveStudent {

	use Singleton;

	private static $id;
	private static $student;

	/**
	 * Magic methods
	 */
	private function __construct() {
		if (DB::exists(Student::TABLE . ' WHERE ' . Student::INDEX . ' = ?', [userId()])) {
			$student = new Student(userId());

			self::$id = $student->id;
			self::$student = new Student(self::$id);
		}
	}

	function __get($property) {
		return self::$id ? self::$student->$property : null;
	}
}
