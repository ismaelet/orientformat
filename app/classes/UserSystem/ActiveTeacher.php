<?php

namespace UserSystem;

use DB;
use Singleton;

class ActiveTeacher {

	use Singleton;

	private static $id;
	private static $teacher;

	/**
	 * Magic methods
	 */
	private function __construct() {
		if (DB::exists(Teacher::TABLE . ' WHERE ' . Teacher::INDEX . ' = ?', [userId()])) {
			$teacher = new Teacher(userId());

			self::$id = $teacher->id;
			self::$teacher = new Teacher(self::$id);
		}
	}

	function __get($property) {
		return self::$id ? self::$teacher->$property : null;
	}

	public function getSchoolClasses(string $type = 'all') {
		self::$teacher->getSchoolClasses($type);
	}
}
