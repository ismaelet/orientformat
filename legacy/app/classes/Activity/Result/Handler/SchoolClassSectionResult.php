<?php

namespace Legacy\Activity\Result\Handler;

use \Legacy\Activity\Result\SectionResult;
use \Legacy\UserSystem\Student;

/**
 * SchoolClassSectionResult class
 * 
 * @property array rawResult
 * @property array studentIds
 */
class SchoolClassSectionResult {

	use \System\Traits\DynamicProperties;

	private $sectionId;
	private $schoolClassId;
	private $filterBy;
	private $range;

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
		if (!$this->schoolClassId && \Legacy\System\Classes\LegacyDB::exists('averages WHERE sectionId = ? AND time > NOW() - INTERVAL 1 MONTH', [$this->sectionId])) {
			// for platform results try to find search the database for updated results
			$rawResult = \Legacy\System\Classes\LegacyDB::find('value FROM averages WHERE sectionId = ? AND time > NOW() - INTERVAL 1 MONTH', [$this->sectionId]);

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
					// Profilo - Stili cognitivi
				case 4:
				case 29:
				case 41:
					// Profilo - Autostima
				case 6:
					// Profilo - Stile attributivo
				case 7:
					// Profilo - Motivazione
				case 8:
					// Profilo - Temperamento
				case 17:
					// Saperi - Creatività
				case 45:
					// Scegliere - Interessi
				case 24:
				case 27:
					// Profilo - La Ruota delle emozioni
					$result = self::calcNamedPercentages();
					break;

				case 3:
					// Profilo - Resilienza
				case 5:
				case 30:
					// Profilo - Risolvere i problemi
				case 9:
				case 31:
					// Competenze - Stare attenti
				case 10:
				case 32:
					// Competenze - Ricordare
				case 11:
				case 33:
					// Competenze - Ascoltare
				case 12:
					// Competenze - Parlare
				case 14:
				case 34:
					// Competenze - Scrivere
				case 39:
					// Competenze - Leggere
				case 40:
					// Competenze - Imparare
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

				\Legacy\System\Classes\LegacyDB::delete('averages WHERE sectionId = ?', [$this->sectionId]);
				\Legacy\System\Classes\LegacyDB::add('averages (sectionId, value)', [$this->sectionId, $sqlResult]);
			}
		}

		return $result;
	}

	// the IDs of the students fitting the current selection
	private function getStudentIds() {
		if (!$this->filterBy) {
			$students = $this->schoolClassId ?
				\Legacy\System\Classes\LegacyDB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?', [$this->schoolClassId])->res :
				\Legacy\System\Classes\LegacyDB::select(Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::INDEX . ' IN (SELECT ' . SectionResult::USER_INDEX . ' FROM ' . SectionResult::TABLE . ' WHERE completed = 1 AND ' . SectionResult::SECTION_INDEX . ' = ?) ORDER BY ' . Student::INDEX . ' DESC', [$this->sectionId])->res;
		} else {
			$students = $this->schoolClassId ?
				\Legacy\System\Classes\LegacyDB::select('* FROM ' . Student::TABLE . ' INNER JOIN students_data ON students.userId = students_data.studentId WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND ' . $this->filterBy . ' >= ? AND ' . $this->filterBy . ' <= ?', [$this->schoolClassId, min($this->range), max($this->range)])->res :
				\Legacy\System\Classes\LegacyDB::select('* FROM ' . Student::TABLE . ' INNER JOIN students_data ON students.userId = students_data.studentId WHERE ' . $this->filterBy . ' >= ? AND ' . $this->filterBy . ' <= ?', [min($this->range), max($this->range)])->res;
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
				$tier = floor(min($result, 99) / 25);
				$rawResults[$tier][1]++;
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
}
