<?php

namespace Legacy\UserSystem;

use \Legacy\SchoolSystem\SchoolClass;

use \Legacy\System\Classes\User;

/**
 * Teacher class
 * 
 * @property array schoolClassIds
 * @property array schoolClasses
 */
class Teacher {

	use \System\Traits\DatabaseObject;

	const TABLE = 'teachers';
	const INDEX = 'userId';

	private function getId() {
		return $this->databaseEntry[self::INDEX];
	}

	private function getFullName() {
		return $this->user->fullName;
	}

	private function getInvertedFullName() {
		return $this->user->fullNameInv;
	}

	private function getUser() {
		return new \Legacy\System\Classes\User($this->id);
	}

	private function getStudentIdsString() {
		return $this->studentIds ? implode(',', $this->studentIds) : false;
	}

	private function getSchoolClassIds(string $type = 'all') {
		$results = [];

		if ($this->id && $this->databaseEntry['classes']) {
			switch ($type) {
				default:
					$schooClassesData = \Legacy\System\Classes\LegacyDB::select(SchoolClass::INDEX . ' FROM ' . SchoolClass::TABLE . ' WHERE FIND_IN_SET(' . SchoolClass::INDEX . ', "' . $this->databaseEntry['classes'] . '") ORDER BY year DESC, grade DESC');
					$results = $schooClassesData->num_rows ? extract_subvalue($schooClassesData->res, 'id') : null;
			}
		}

		return $results;
	}

	public function getSchoolClasses(string $type = 'all') {
		$schoolClasses = false;

		if ($this->schoolClassIds) {
			$schoolClasses = [];

			foreach ($this->schoolClassIds as $schoolClassId) {
				if (!empty($schoolClassId) && \Legacy\System\Classes\LegacyDB::exists(SchoolClass::TABLE . ' WHERE ' . SchoolClass::INDEX . ' = ?', $schoolClassId)) {
					$schoolClasses[] = new SchoolClass($schoolClassId);
				}
			}
		}

		return $schoolClasses;
	}

	private function getSchoolClassCount() {
		return $this->schoolClasses ? count($this->schoolClasses) : 0;
	}

	private function getStudentIds() {
		$studentIds = false;

		if ($this->schoolClassIds) {
			$schoolClassIdsString = implode(',', $this->schoolClassIds);
			$res = \Legacy\System\Classes\LegacyDB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE FIND_IN_SET (' . Student::SCHOOL_CLASS_INDEX . ', ?)', [$schoolClassIdsString]);
			$studentIds = $res->num_rows ? array_column($res->res, Student::INDEX) : null;
		}

		return $studentIds;
	}
}
