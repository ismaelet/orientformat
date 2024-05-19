<?php

namespace Legacy\UserSystem;

use LegacyDB;


class ActiveTeacher {

	use \System\Traits\Singleton;

	private static $id;
	private static $teacher;

	/**
	 * Magic methods
	 */
	private function __construct() {
		if (\Legacy\System\Classes\LegacyDB::exists(Teacher::TABLE . ' WHERE ' . Teacher::INDEX . ' = ?', [userId()])) {
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
