<?php

namespace Legacy\Activity\Result\Handler;

use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Section;
use \Legacy\Activity\Test;
use LegacyModels\Activities\Results\CondensedSectionResult;
use LegacyModels\Activities\Section as SectionModel;
use LegacyDB;
use System\Traits\DynamicProperties;
use User;

/**
 * StudentSectionResult class
 *
 * @property string result
 * @property array detailedResult
 * @property object staticResult
 * 
 * @property object section
 */
class StudentSectionResult {

	use \System\Traits\DynamicProperties;

	private const MAIN_TEST_IDS = [
		1 => 31,
		3 => 49,
		4 => 15,
		6 => 48,
		7 => 20,
		8 => 46,
		17 => 81,
		18 => 82,
		24 => 92,
		25 => 100,
		26 => 101,
		27 => 116,
		28 => 109,
		29 => 107,
		36 => 111,
		37 => 113,
		41 => 146,
		45 => 151,
	];

	private $sectionId;
	private $section;
	private $studentId;

	/**
	 * Magic methods
	 */
	function __construct(int $sectionId, $studentId = null) {
		$this->sectionId = $sectionId;
		$this->studentId = $studentId ?: studentId();
		$this->section = (new Section($this->sectionId))->setStudentId($this->studentId);
	}

	/**
	 * Get methods
	 */
	private function getStaticResult() {
		$row = \Legacy\System\Classes\LegacyDB::row('* FROM ' . CondensedSectionResult::table() . ' WHERE ' . CondensedSectionResult::linkedIndexName(User::class) . ' = ? AND ' . CondensedSectionResult::linkedIndexName(SectionModel::class) . ' = ?', [$this->studentId, $this->sectionId]);

		return $row ? $row : null;
	}

	private function getResult() {
		if ($this->staticResult) {
			return $this->staticResult[CondensedSectionResult::resultIndex()];
		} else {
			switch ($this->sectionId) {
				case 9:
					// stare attenti
					$result = $this->calcStareAttenti();
					break;

				case 5:
				case 30:
				case 38:
				case 42:
					// risolvere problemi
				case 10:
					// ricordare
				case 11:
				case 32:
				case 33:
				case 48:
				case 49:
					// ascoltare
				case 12:
				case 47:
				case 50:
					// parlare
				case 13:
				case 39:
					// leggere
				case 14:
				case 51:
				case 53:
				case 54:
				case 55:
					// scrivere
				case 15:
				case 40:
				case 56:
					// imparare
				case 31:
				case 34:
				case 57:
					// stare attenti
					$result = $this->calcAverage();
					break;

				default:
					if (isset(self::MAIN_TEST_IDS[$this->sectionId])) {
						$result = (new StudentTestResult(self::MAIN_TEST_IDS[$this->sectionId], $this->studentId))->result;
					} else {
						$result = null;
					}
			}

			CondensedSectionResult::add([
				CondensedSectionResult::linkedIndexName(User::class) => $this->studentId,
				CondensedSectionResult::linkedIndexName(SectionModel::class) => $this->sectionId,
				CondensedSectionResult::resultIndex() => $result,
				CondensedSectionResult::speedIndex() => $this->calcSpeed(),
			]);

			return $result;
		}
	}

	private function getDetailedResult() {
		switch ($this->sectionId) {
			case 5:
			case 30:
			case 38:
			case 42:
				// risolvere problemi
				return $this->calcFullSectionResults([94, 119, 147, 162]);

			case 9:
				// stare attenti
				return $this->calcDetailedStareAttenti();

			case 10:
			case 32:
			case 49:
				// ricordare
				return $this->calcFullSectionResults([56]);

			case 11:
			case 33:
			case 47:
			case 48:
				// ascoltare
				return $this->calcFullSectionResults();

			case 12:
			case 50:
				// parlare
				return $this->calcFullSectionResults();

			case 13:
			case 39:
			case 53:
			case 54:
				// leggere
				return $this->calcFullSectionResults([70]);

			case 14:
			case 34:
			case 51:
			case 55:
			case 57:
				// scrivere
				return $this->calcFullSectionResults([62, 63, 167, 168]);

			case 15:
			case 40:
			case 56:
				// imparare
				return $this->calcFullSectionResults([131]);

			case 31:
				// stare attenti
				return $this->calcFullSectionResults();

			default:
				if (isset(self::MAIN_TEST_IDS[$this->sectionId])) {
					return (new StudentTestResult(self::MAIN_TEST_IDS[$this->sectionId], $this->studentId))->detailedResult;
				} else {
					return null;
				}
		}
	}

	/**
	 * General results
	 */
	private function calcFullSectionResults(array $skipTestIds = []) {
		$results = [];

		foreach ($this->section->tests as $test) {
			$test->setStudentId($this->studentId);

			if ($test->completed && !in_array($test->id, $skipTestIds) && $test->template != 'survey-results') {
				$results[] = [
					'test' => $test->title,
					'percentage' => (int) (new StudentTestResult($test->id, $this->studentId))->result,
				];
			}
		}

		return $results;
	}

	private function calcAverage() {
		$total = 0;

		foreach ($this->detailedResult as $result) {
			$total += $result['percentage'];
		}

		return $this->detailedResult ? round($total / count($this->detailedResult)) . '%' : null;
	}

	/**
	 * Section specific
	 */
	private function calcStareAttenti() {
		if ($this->detailedResult) {
			$average = 0;

			if (isset($this->detailedResult['Autovalutazione'])) {
				$average += $this->detailedResult['Autovalutazione']['percentage'];
			}

			if (isset($this->detailedResult['Iperattività'])) {
				$average += 100 - $this->detailedResult['Iperattività']['percentage'];
			}

			if (isset($this->detailedResult['Distraibilità'])) {
				$average += 100 - $this->detailedResult['Distraibilità']['percentage'];
			}

			return round($average / count($this->detailedResult)) . '%';
		} else {
			return null;
		}
	}

	private function calcDetailedStareAttenti() {
		$results = [];
		$selfEvalutation = (new StudentTestResult(16, $this->studentId));
		$hyper = (new StudentTestResult(21, $this->studentId));
		$selfEvalutationResult = $selfEvalutation->detailedResult;
		$hyperResults = $hyper->detailedResult;

		if ($selfEvalutationResult !== null) {
			$results['Autovalutazione'] =
				[
					'name' => 'Autovalutazione',
					'value' => $selfEvalutationResult,
					'percentage' => $selfEvalutationResult,
				];
		}

		if ($hyperResults !== null) {
			foreach ($hyperResults as $resultName => $result) {
				$results[$resultName] = [
					'name' => $resultName,
					'value' => $result,
					'percentage' => round($result / 36 * 100),
				];
			}
		}

		return empty($results) ? null : $results;
	}

	/**
	 * Speed
	 */
	public function getSpeed() {
		if ($this->staticResult) {
			return $this->staticResult[CondensedSectionResult::speedIndex()];
		} else {
			return $this->calcSpeed();
		}
	}

	private function calcSpeed() {
		return \Legacy\System\Classes\LegacyDB::sum('speed FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ?' . ' AND ' . TestResult::TEST_INDEX . ' IN (SELECT ' . Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ?)', [$this->studentId, $this->sectionId]) ?: 0;
	}

	public function getSpeedString() {
		$speedString = null;

		if ($this->speed >= 60) {
			$minutes = round($this->speed / 60);

			$speedString = $minutes;
			$speedString .= $minutes == 1 ? ' minuto' : ' minuti';
		} else if ($this->speed) {
			$seconds = $this->speed;

			$speedString = $seconds;
			$speedString .= $seconds == 1 ? ' secondo' : ' secondi';
		}

		return $speedString;
	}
}
