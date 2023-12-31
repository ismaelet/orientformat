<?php

namespace Activity\Result\Handler;

use Activity\Result\SectionResult;
use DB;
use DynamicProperties;
use UserSystem\Student;

/**
 * SchoolClassSectionResult class
 * 
 * @property array rawResult
 * @property array studentIds
 */
class SchoolClassSectionResult {

	use DynamicProperties;

	private $sectionId;
	private $schoolClassId;
	private $filterBy;
	private $range;
	private static $singleTestSections = [11 => 27];

	/**
	 * Magic methods
	 */
	function __construct(int $sectionId, $schoolClassId = null, $filterBy = null, $range = []) {
		$this->sectionId = $sectionId;
		$this->schoolClassId = $schoolClassId ?: null;
		$this->filterBy = $filterBy;
		$this->range = $range;
	}

	/**
	 * Get methods
	 */
	public function getResult() {
		switch ($this->sectionId) {
			case 1:
				// stili cognitivi

			case 4:
				// autostima
				return self::calcAveragePercentage();

			case 8:
				// resilienza
				return self::calcMaxNameValue();
		}
	}

	public function getRawResult() {
		if (!$this->schoolClassId && DB::exists('averages WHERE sectionId = ? AND time > NOW() - INTERVAL 1 MONTH', [$this->sectionId])) {
			// for platform results try to find search the database for updated results
			$rawResult = DB::find('value FROM averages WHERE sectionId = ? AND time > NOW() - INTERVAL 1 MONTH', [$this->sectionId]);

			if (strpos($rawResult, ',') === false) {
				$result['values'] = $rawResult;
			} else {
				$result['values'] = [];
				$rawResult = explode(',', $rawResult);

				foreach ($rawResult as $rawElement) {
					$rawElement = explode(':', $rawElement);
					$result['values'][str_replace(';', ',', $rawElement[0])] = $rawElement[1];
				}
			}
		} else {
			// otherwise and for class results or if the platform results are outdated, calculate the results
			switch ($this->sectionId) {
				case 1:
				case 28:
				case 36:
				case 37:
					// stili
				case 4:
				case 29:
				case 41:
					// autostima
				case 6:
					// stile attributivo
				case 7:
					// motivazione
				case 24:
					// interessi
				case 27:
				case 45:
					// ruota delle emozioni
					$result = self::calcNamedPercentages();
					break;

				case 11:
					// Ascoltare
					$result = self::calcTierResult();
			}

			// store platform results
			if (!$this->schoolClassId) {
				if (!is_array($result['values'])) {
					$sqlResult = $result['values'];
				} else {
					$sqlResult = [];

					foreach ($result['values'] as $resultKey => $resultValue) {
						$sqlResult[] = str_replace(',', ';', $resultKey) . ':' . $resultValue;
					}

					$sqlResult = implode(',', $sqlResult);
				}

				DB::delete('averages WHERE sectionId = ?', [$this->sectionId]);
				DB::add('averages (sectionId, value)', [$this->sectionId, $sqlResult]);
			}
		}

		return $result;
	}

	// the IDs of the students fitting the current selection
	private function getStudentIds() {
		if (!$this->filterBy) {
			$students = $this->schoolClassId ?
				DB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?', [$this->schoolClassId])->res :
				DB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::INDEX . ' IN (SELECT ' . SectionResult::USER_INDEX . ' FROM ' . SectionResult::TABLE . ' WHERE completed = 1 AND ' . SectionResult::SECTION_INDEX . ' = ?) ORDER BY ' . Student::INDEX . ' DESC LIMIT ?', [$this->sectionId, 1000])->res;
		} else {
			$students = $this->schoolClassId ?
				DB::select('* FROM ' . Student::TABLE . ' INNER JOIN students_data ON students.userId = students_data.studentId WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND ' . $this->filterBy . ' >= ? AND ' . $this->filterBy . ' <= ?', [$this->schoolClassId, min($this->range), max($this->range)])->res :
				DB::select('* FROM ' . Student::TABLE . ' INNER JOIN students_data ON students.userId = students_data.studentId WHERE ' . $this->filterBy . ' >= ? AND ' . $this->filterBy . ' <= ?', [min($this->range), max($this->range)])->res;
		}

		return $students ? array_column($students, 'userId') : null;
	}

	/*
	* Misc methods
	*/
	// general methods
	private function calcMaxNameValue() {
		return array_keys($this->rawResult['values'], max($this->rawResult['values']))[0];
	}

	private function calcAveragePercentage() {
		$percentage = 0;
		$count = 0;

		foreach ($this->rawResult['values'] as $result) {
			$percentage += $result;
			$count++;
		}

		return round($percentage / $count) . '%';
	}

	/**
	 * Section specfic methods
	 */
	private function calcNamedPercentages() {
		$count = 0;
		$results = ['values' => [], 'count' => 0];

		if ($this->studentIds) {
			foreach ($this->studentIds as $studentId) {
				$studentResult = (new StudentSectionResult($this->sectionId, $studentId))->detailedResult;

				if ($studentResult) {
					$count++;

					foreach ($studentResult as $key => $studentResultData) {
						if (!isset($results['values'][$studentResultData['name']])) {
							$results['values'][$studentResultData['name']] = 0;
						}

						$results['values'][$studentResultData['name']] += $studentResultData['percentage'];
					}
				}
			}

			$results['count'] = $count;

			foreach ($results['values'] as &$value) {
				$value = round($value / $count);
			}
		}

		return $results;
	}

	private function calcTierResult() {
		$count = 0;
		$results = [];
		$rawResults = [['Basso', 0], ['Medio', 0], ['Alto', 0], ['Molto alto', 0]];

		foreach (self::getStudentIds() as $studentId) {
			$result = (new StudentSectionResult($this->sectionId, $studentId))->result;

			if ($result) {
				$count++;
				$result = explode('%', $result)[0];
				$tier = floor($result / 20);
				$rawResults[$tier - 1][1]++;
			}
		}

		if ($count) {
			$results['count'] = $count;

			foreach ($rawResults as $rawResult) {
				$results['values'][$rawResult[0]] = percent($rawResult[1], $count);
			}
		}

		return $results;
	}

	/**
	 * OLD
	function parseToString($sectionId, $results) {
		$resultStr = false;

		if (isset($results['average']) || isset($results['values'])) {
			$values = $results['average'] ?? $results['values'];
		} else {
			$values = $results;
		}

		if ($results !== false) {
			switch ($sectionId) {
				case 14:
					if (is_array($values)) {
						$values = round(array_sum($values) / count($values));
					}

					$tierNames = section_config($sectionId, 'tiers');
					$tier = floor((max($values, 1) - 1) / 20);
					$tierName = $tierNames[$tier];
					$resultStr = $tierName . ' (' . $values . '%)';

					break;

				default:
					$resultStr = SectionResult::parseToString($sectionId, $values);

					break;
			}
		}

		return $resultStr;
	}

	// calculate the average result of a section for a class or for the whole platform

	// calculate speed
	static public function speed($gradeId, $sectionId) {
		$speedStr = '';
		$row = DB::row('SUM(speed) as tot, COUNT(*) as count FROM ' . TestResult::TABLE . ' WHERE testID IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ?) AND completed = 1 AND speed > 59', [$sectionId]);
		$speed = $row['count'] ? round($row['tot'] / $row['count']) : 0;
		if ($speed < 40) $speed = 0;
		if ($speed >= 60) {
			$minutes = round($speed / 60);
			$speedStr .= $minutes;
			$speedStr .= $minutes == 1 ? ' minuto' : ' minuti';
		} else if ($speed) {
			$seconds = $speed;
			$speedStr .= $seconds;
			$speedStr .= $seconds == 1 ? ' secondo' : ' secondi';
		}
		return $speedStr;
	}

	// calculate result
	private function getParameterAverage($gradeId, $testIds, $studentIds) {
		$results['values'] = false;
		$results['count'] = 0;
		$testIdsStr = implode(',', $testIds);
		$studentIds = $studentIds ? implode(',', $studentIds) : false;

		if ($studentIds || !$gradeId) {

			// result values
			foreach ($testIds as $testId) {
				if ($gradeId) {
					$result = DB::row("SUM(percentage) as tot, COUNT(*) as count FROM " . TestResult::TABLE . " WHERE " . TestResult::USER_INDEX . " IN (' . $studentIds . ') AND testID = ? AND completed = 1", [$testId]);
				} else {
					$result = DB::row("SUM(percentage) as tot, COUNT(*) as count FROM " . TestResult::TABLE . " WHERE testID = ? AND completed = 1", [$testId]);
				}
				$testName = DB::find('title FROM ' . Test::TABLE . ' WHERE id = ?', [$testId]);
				$results['values'][$testName] = $result['count'] ? round($result['tot'] / $result['count']) : false;
			}
		}

		if ($gradeId) {
			if ($studentIds) {
				if (DB::exists("results WHERE " . TestResult::TEST_INDEX . " IN (" . $testIdsStr . ") AND " . TestResult::USER_INDEX . " IN (' . $studentIds . ') AND completed = 1")) {
					$results['count'] = DB::count("results WHERE " . TestResult::TEST_INDEX . " IN (" . $testIdsStr . ") AND " . TestResult::USER_INDEX . " IN (' . $studentIds . ') AND completed = 1 GROUP BY testID");
				}
			}
		} else {
			$results['count'] = DB::count("results WHERE " . TestResult::TEST_INDEX . " IN (" . $testIdsStr . ") AND completed = 1 GROUP BY testID");
		}

		return $results;
	}

	// calculate result
	private function getTierAverage($sectionId, $gradeId, $testIds, $studentIds) {
		$tierNames = section_config($sectionId, 'tiers');
		$results['values'] = false;
		$results['count'] = 0;
		$testIdsStr = array_to_sql($testIds);
		$studentIds = array_to_sql($studentIds);

		if ($studentIds || !$gradeId) {
			if ($gradeId) {
				/*
	 * Grade values divided by tier
				// unsorted results
				$unsortedResults = [];
				$resultsData = DB::select('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (' . $studentIds . ') AND testID IN (' . $testIdsStr . ') AND completed = 1');

				while ($resultData = $resultsData->fetch_assoc()) {
					$tier = floor((max($resultData['percentage'], 1) - 1) / 20);
					$tierName = $tierNames[$tier];
					if (!isset($unsortedResults[$tierName])) $unsortedResults[$tierName] = 0;
					$unsortedResults[$tierName]++;
				}

				// sort results
				foreach ($tierNames as $tierName) {
					$results['values'][$tierName] = $unsortedResults[$tierName] ?? 0;
				}

				// average
				$averageData = DB::row('SUM(percentage) as tot, COUNT(*) as count FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (' . $studentIds . ') AND testID IN (' . $testIdsStr . ') AND completed = 1 GROUP BY testID');
				$results['count'] = $averageData['count'] ?? 0;
				$results['average'] = $results['count'] ? round($averageData['tot'] / $results['count']) : false;
			} else {
				/*
	 * Platform average
				foreach ($tierNames as $tierId => $tierName) {
					$tierValMin = $tierId * 20;
					$tierValMax = ($tierId + 1) * 20;

					if (!$tierValMin) {
						$result = DB::row('SUM(percentage) as tot, COUNT(*) as count FROM ' . TestResult::TABLE . ' WHERE testID IN (' . $testIdsStr . ') AND completed = 1 AND percentage >= ? AND percentage <= ? GROUP BY testID', [$tierValMin, $tierValMax]);
					} else {
						$result = DB::row('SUM(percentage) as tot, COUNT(*) as count FROM ' . TestResult::TABLE . ' WHERE testID IN (' . $testIdsStr . ') AND completed = 1 AND percentage > ? AND percentage <= ? GROUP BY testID', [$tierValMin, $tierValMax]);
					}

					$results['values'][$tierName] = $result['count'] ?? 0;
				}

				$result = DB::row('SUM(percentage) as tot, COUNT(*) as count FROM ' . TestResult::TABLE . ' WHERE testID IN (' . $testIdsStr . ') AND completed = 1 GROUP BY testID');
				$results['values']['average'] = !empty($result['count']) ? round($result['tot'] / $result['count']) : 0;
			}
		}

		return $results;
	}

	/*
	 * Section specific
	// stili cognitivi
	private function calcStileAttributivo($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];
		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');
			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}
		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = \Student\SectionTestResult::getRawResult($studentId, 6);
				if ($studentResults) {
					$count++;
					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) $results['values'][$key] = 0;
						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}
		$results['count'] = $count;
		$maxValue = array_sum($results['values']);
		foreach ($results['values'] as &$value) {
			$value = round($value / $maxValue * 100);
		}
		return $results;
	}

	/*
	 * Temperamento
	 */
	/*private function calcTemperamento($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];

		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');

			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}

		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = \Student\SectionTestResult::getRawResult($studentId, 8);

				if ($studentResults) {
					$count++;

					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) $results['values'][$key] = 0;
						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}

		$results['count'] = $count;

		foreach ($results['values'] as &$value) {
			$value = round($value / $results['count']);
		}

		return $results;
	}*/

	/*
	* Motivazione
	private function calcMotivazione($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];
		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');
			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}
		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = SectionResult::getRawResult($studentId, 7);
				if ($studentResults) {
					$count++;
					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) $results['values'][$key] = 0;
						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}
		$results['count'] = $count;
		$maxValue = array_sum($results['values']);
		foreach ($results['values'] as &$value) {
			$value = round($value / $maxValue * 100);
		}
		return $results;
	}

	/*
	* Attenzione
	private function calcAttenzione($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];
		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');
			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}
		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = SectionResult::getRawResult($studentId, 9);
				if ($studentResults) {
					$count++;
					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) $results['values'][$key] = 0;
						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}
		$results['count'] = $count;
		$maxValue = array_sum($results['values']);
		foreach ($results['values'] as &$value) {
			$value = round($value / $maxValue * 100);
		}
		return $results;
	}

	/*
	* Scrivere
	private function calcScrivere($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];

		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');

			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}

		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = \Student\SectionTestResult::getRawResult($studentId, 14);

				if ($studentResults) {
					$count++;

					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) $results['values'][$key] = 0;
						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}

		$results['count'] = $count;

		foreach ($results['values'] as &$value) {
			$value = round($value / $results['count']);
		}

		return $results;
	}

	/*
	* Interessi
	private function calcInteressi($gradeId, $studentIds) {
		$count = 0;
		$results['values'] = [];

		if (!$gradeId) {
			$studentIds = [];
			$studentsData = DB::select('userId FROM students');

			while ($studentData = $studentsData->fetch_assoc()) {
				$studentIds[] = $studentData['userId'];
			}
		}

		if ($studentIds) {
			foreach ($studentIds as $studentId) {
				$studentResults = SectionResult::getRawResult($studentId, 24);

				if ($studentResults) {
					$count++;

					foreach ($studentResults as $key => $CondensedTestResult) {
						if (!isset($results['values'][$key])) {
							$results['values'][$key] = 0;
						}

						$results['values'][$key] += $CondensedTestResult;
					}
				}
			}
		}

		$results['count'] = $count;

		foreach ($results['values'] as &$value) {
			$value = round($value / $results['count']);
		}

		return $results;
	}*/
}
