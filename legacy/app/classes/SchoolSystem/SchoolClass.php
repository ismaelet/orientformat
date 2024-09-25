<?php

namespace Legacy\SchoolSystem;

use Illuminate\Support\Facades\Log;
use \Legacy\Activity\Area;
use \Legacy\Activity\Section;
use \Legacy\UserSystem\Student;
use \Legacy\UserSystem\Teacher;

/**
 * School Class class
 * 
 * @property string name
 * @property string letter
 * 
 * @property object grade
 * @property int currentGrade
 * @property int relativeGrade
 * @property int minimumGrade
 * @property string fullGrade
 * @property string yearRangeString
 * 
 * @property bool isMiddleSchool
 * @property bool isHighSchool
 * @property bool isProfessional
 * 
 * @property int schoolId
 * @property object school
 * 
 * @property int studentCount
 * @property array students
 * @property array studentIds
 * 
 * @property array doableSectionIds
 * @property string doableSectionIdsString
 * @property array doableAreas
 * @property array doableAreaIds 
 * @property string doableAreaIdsString 
 */
class SchoolClass {

	public const TABLE = 'school_classes';
	public const INDEX = 'id';
	public const SCHOOL_INDEX = 'schoolId';

	use \System\Traits\DatabaseObject;

	/**
	 * Get methods
	 */
	private function getSchool() {
		return new School($this->{self::SCHOOL_INDEX});
	}

	private function getStudentCount() {
		return \App\Legacy\LegacyDB::count(Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?', [$this->id]);
	}

	private function getActiveStudentCount() {
		return \App\Legacy\LegacyDB::count(Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND status = 1', [$this->id]);
	}

	private function getStudents() {
		return rows_to_objects(\App\Legacy\LegacyDB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?', [$this->id]), Student::class);
	}

	private function getActiveStudents() {
		return rows_to_objects(\App\Legacy\LegacyDB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND status = 1', [$this->id]), Student::class);
	}

	private function getStudentIds() {
		$studentIds = [];

		foreach ($this->students as $student) {
			$studentIds[] = $student->id;
		}

		return $studentIds;
	}

	private function getActiveStudentIds() {
		$studentIds = [];
		foreach ($this->activeStudents as $student) {
			$studentIds[] = $student->id;
		}

		return $studentIds;
	}

	private function getStudentIdsString() {
		return implode(',', $this->studentIds);
	}

	private function getActiveStudentIdsString() {
		return implode(',', $this->activeStudentIds);
	}

	private function getName() {
		return $this->isHighSchool ? $this->letter : $this->relativeGrade . $this->letter;
	}

	private function getFullName() {
		return $this->name . ' (' . $this->yearRangeString . ')' . ' ' . $this->school->name;
	}

	private function getGrade() {
		if (!$this->databaseEntry['grade']) {
			Log::error('No grade found for class ' . $this->id, ['class' => $this, 'user' => auth()->user()]);
		}

		return new Grade($this->databaseEntry['grade'], $this);
	}

	private function getCurrentGrade() {
		return $this->grade->id;
	}

	private function getRelativeGrade() {
		return $this->grade->relativeId;
	}

	private function getFullGrade() {
		return $this->grade ? $this->grade->fullId : null;
	}

	private function getMinimumGrade() {
		return $this->isMiddleSchool ? 1 : 4;
	}

	private function getLastActiveYear() {
		$gradeProgress = $this->currentGrade - $this->startingGrade;

		return $this->startingYear + $gradeProgress;
	}

	private function getYearRangeString() {
		return $this->lastActiveYear . ' - ' . ($this->lastActiveYear + 1);
	}

	private function getIsMiddleSchool() {
		return $this->grade->isMiddleSchool;
	}

	private function getIsHighSchool() {
		return $this->grade->isHighSchool;
	}

	private function getIsProfessional() {
		return (bool) $this->professional;
	}

	private function getDoableSectionIds() {
		return $this->grade->doableSectionIds;
	}

	private function getDoableSectionIdsString() {
		return implode(',', $this->doableSectionIds);
	}

	private function getDoableAreas() {
		return rows_to_objects(\App\Legacy\LegacyDB::select(Area::INDEX . ' FROM ' . Area::TABLE . ' WHERE ' . Area::INDEX . ' IN (SELECT ' . Section::AREA_INDEX . ' FROM activities_sections WHERE FIND_IN_SET(id, "' . $this->doableSectionIdsString . '"))', []), Area::class);
	}

	private function getReferent() {
		return new Teacher($this->referentId);
	}
}
