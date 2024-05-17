<?php

namespace Legacy\Activity\Result;

/**
 * TestResult class
 * 
 * @property array rawResults
 * @property array detailedResult
 */
class TestResult {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'results_tests';
	public const INDEX = 'id';
	public const USER_INDEX = 'studentId';
	public const TEST_INDEX = 'testId';

	/**
	 * Get methods
	 */
	private function getRawResults() {
		return explode(',', (string) $this->result);
	}

	/**
	 * Istance methods
	 */
	public static function new(array $data) {
		\System\Classes\DBOld::delete(self::TABLE . ' WHERE ' . self::USER_INDEX . ' = ? AND ' . self::TEST_INDEX . ' = ?', [$data['studentId'], $data['testId']]);

		// save results
		$id = \System\Classes\DBOld::add(
			self::TABLE . ' (' . self::USER_INDEX . ', ' . self::TEST_INDEX . ', result, percentage, completed, speed)',
			[$data['studentId'], $data['testId'], $data['results'], $data['percentage'], $data['completed'], $data['speed']]
		);

		// permanent record
		if (!\System\Classes\DBOld::exists('results_permanent WHERE studentId = ? AND testId = ?', [$data['studentId'], $data['testId']])) {
			self::saveToPermanentRecord($data);
		}
	}

	private static function saveToPermanentRecord(array $data) {
		\System\Classes\DBOld::add(
			'results_permanent (studentId, testId, result, percentage, speed)',
			[$data['studentId'], $data['testId'], $data['results'], $data['percentage'], $data['speed']]
		);
	}
}
