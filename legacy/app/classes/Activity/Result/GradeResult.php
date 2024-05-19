<?php

namespace Legacy\Activity\Result;

use DatabaseObject;
use LegacyDB;

/**
 * GradeResult class
 */
class GradeResult {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'results_grades';
	public const INDEX = 'id';
	public const USER_INDEX = 'studentId';
	public const GRADE_INDEX = 'gradeId';

	/**
	 * Get methods
	 */
	private function getStudentId() {
		return $this->databaseEntry[self::USER_INDEX];
	}

	/**
	 * Istance methods
	 */
	public static function new(int $gradeId) {
		return \Legacy\System\Classes\LegacyDB::add(self::TABLE . ' (' . self::USER_INDEX . ', ' . self::GRADE_INDEX . ')', [\Illuminate\Support\Facades\Auth::id(), $gradeId]);
	}
}
