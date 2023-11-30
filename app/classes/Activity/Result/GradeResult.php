<?php

namespace Activity\Result;

use DatabaseObject;
use DB;

/**
 * GradeResult class
 */
class GradeResult {

	use DatabaseObject;

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
		return DB::add(self::TABLE . ' (' . self::USER_INDEX . ', ' . self::GRADE_INDEX . ')', [studentId(), $gradeId]);
	}
}
