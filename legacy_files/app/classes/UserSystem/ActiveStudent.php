<?php

namespace Legacy\UserSystem;

class ActiveStudent {

	use \System\Traits\Singleton;

	private static $id;
	private static $student;

	/**
	 * Magic methods
	 */
	private function __construct() {
		if (\System\Classes\DBOld::exists(Student::TABLE . ' WHERE ' . Student::INDEX . ' = ?', [userId()])) {
			$student = new Student(userId());

			self::$id = $student->id;
			self::$student = new Student(self::$id);
		}
	}

	function __get($property) {
		return self::$id ? self::$student->$property : null;
	}
}
