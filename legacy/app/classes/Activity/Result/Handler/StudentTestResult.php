<?php

namespace Legacy\Activity\Result\Handler;

use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Test;
use LegacyDB;
use System\Traits\DynamicProperties;

/**
 * Class CondensedTestResult
 *
 * @property int resultId
 * @property string result
 * @property array detailedResult
 * @property array rawResults
 * 
 * @property object test
 */
class StudentTestResult {

	use \System\Traits\DynamicProperties;

	private $testId;
	private $legacyTest;
	private $studentId;

	/**
	 * Magic methods
	 */
	function __construct(int $testId, int $studentId = null) {
		$this->testId = $testId;
		$this->studentId = $studentId ?: watchedStudentId();
		$this->test = (new Test($this->testId))->setStudentId($this->studentId);
	}

	/**
	 * Get methods
	 */
	private function getResultId() {
		return \App\Legacy\LegacyDB::find(TestResult::INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::TEST_INDEX . ' = ? AND ' . TestResult::USER_INDEX . ' = ?', [$this->testId, $this->studentId]);
	}

	private function getRawResults() {
		return (new TestResult($this->resultId))->rawResults;
	}

	private function getResult() {
		switch ($this->testId) {
			case 20:
				// motivazione e aree di interesse > mappa
			case 31:
			case 113:
				// stili > mappa
			case 46:
				// temperamento
			case 109:
			case 111:
				// i miei interessi
			case 92:
			case 151:
				return $this->calcMaxNameValue();

			case 15:
			case 107:
			case 146:
				// autostima
				return $this->calcAveragePercentage();

			case 48:
				return $this->calcMaxNameValue();

			case 63:
			case 168:
				// scrivere > mappa degli stili
				return $this->calcAveragePercentage();

			case 81:
				// creatività
				return $this->calcAveragePercentage();

			case 82:
				// albero dei saperi informali
				return $this->calcCompleted();

			case 100:
				// universo personale
				return $this->checkCompleted();

			case 101:
				// l'albero della vita
				return $this->detailedResult;

			case 116:
				// l'albero della vita
				return $this->mergeNames();

			default:
				return $this->calcResult();
		}
	}

	private function getDetailedResult() {
		switch ($this->testId) {
			case 15:
			case 107:
			case 146:
				// autostima
				return $this->calcDetailedTestsAverage();

			case 16:
				// stare attenti - autovalutazione
				return $this->calcPercentage();

			case 20:
				// motivazione e aree di interesse > mappa
				return $this->calcDetailedMotivazioneMappa();

			case 21:
				// stare attenti - iperattività
				return $this->calcDetailedAttenzioneIperattività();

			case 31:
			case 109:
			case 111:
			case 113:
				// stili cognitivi > mappa
				return $this->calcDetailedStiliCongitiviMappa();

			case 46:
				// temperamento
				return $this->calcTemperamento();

			case 48:
				// stile attributivo
				return $this->calcStileAttributivo();

			case 63:
			case 168:
				// scrivere
				return $this->calcDetailedScrivereStili();

			case 81:
				// creatività
				return $this->calcDetailedTestsAverage();

			case 92:
			case 151:
				// i miei interessi
				return $this->calcDetailedInteressi();

			case 101:
				// i miei interessi
				return $this->calcDetailedAlberoVita();

			case 116:
				// la ruota delle emozioni
				return $this->calcDetailedRuotaEmozioni();

			default:
				return $this->calcDetailedResult();
		}
	}

	/**
	 * Set methods
	 */
	public function setRawResults(array $rawResults) {
		$this->data['rawResults'] = $rawResults;

		return $this;
	}

	/**
	 * Misc methods
	 */
	// generic calculators
	private function calcDetailedResult() {
		$legacyTest = $this->test->hasRequiredTest ? $this->test->requiredTest->setStudentId($this->studentId) : $this->test;

		return $legacyTest->completed ? $legacyTest->rawResults : null;
	}

	private function calcPercentage() {
		$legacyTest = $this->test->hasRequiredTest ? $this->test->requiredTest->setStudentId($this->studentId) : $this->test;

		return $legacyTest->completed ? $legacyTest->percentage : null;
	}

	private function calcCompleted() {
		return $this->test->completed ? 'Completato' : null;
	}

	private function calcMaxNameValue() {
		$mainStyle = null;
		$maxiumValue = 0;

		if ($this->detailedResult) {
			foreach ($this->detailedResult as $result) {
				if ($result['value'] >= $maxiumValue) {
					$mainStyle = $result['name'];
					$maxiumValue = $result['value'];
				}
			}
		}

		return $mainStyle;
	}

	private function calcAveragePercentage() {
		$percentage = 0;
		$count = 0;

		foreach ($this->detailedResult as $result) {
			$percentage += $result['percentage'];
			$count++;
		}

		return $count ? round($percentage / $count) . '%' : null;
	}

	private function checkCompleted() {
		return \App\Legacy\LegacyDB::exists(Test::TABLE . ' WHERE ' . Test::INDEX . ' = ?', [$this->testId]) ? 'Completato' : null;
	}

	private function mergeNames() {
		return $this->detailedResult ? implode(', ', extract_subvalue($this->detailedResult, 'name')) : null;
	}

	/**
	 * Test specific methods
	 */
	// Test 31 - Stili Cognitivi - Mappa
	private function calcDetailedStiliCongitiviMappa() {
		$results = [];
		$groups = test_config($this->testId, 'groups');
		$rawResults = ($this->test->requiredTest)
			->setStudentId($this->studentId)
			->rawResults;

		if ($rawResults) {
			foreach ($groups as $groupId => $group) {
				$results[$groupId] = [];
				$results[$groupId]['name'] = $group['name'];
				$results[$groupId]['value'] = 0;
				$results[$groupId]['max'] = 9;

				foreach ($group['questionIds'] as $questionId) {
					$results[$groupId]['value'] += $rawResults[$questionId];
				}
			}
		}

		foreach ($results as &$result) {
			$result['percentage'] = round($result['value'] / $result['max'] * 100);
		}

		return $results;
	}

	// Autostima and Creatività
	private function calcDetailedTestsAverage() {
		$results = [];
		$legacyTests = rows_to_objects(\App\Legacy\LegacyDB::select(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ? AND step < ? ORDER BY step ASC', [$this->test->sectionId, $this->test->step]), Test::class);

		foreach ($legacyTests as $legacyTest) {
			$legacyTest->setStudentId($this->studentId);

			if ($legacyTest->completed) {
				$results[] = [
					'name' => $legacyTest->title,
					'value' => $legacyTest->percentage,
					'percentage' => $legacyTest->percentage,
				];
			}
		}

		return $results;
	}

	// Test 20 - Motivazione e aree di interesse - Mappa
	private function calcDetailedMotivazioneMappa() {
		$results = [];
		$rawResults = ($this->test->requiredTest)
			->setStudentId($this->studentId)
			->rawResults;
		$areas = test_config(20, 'areas');
		$questions = test_config(20, 'questions');

		if ($rawResults) {
			foreach ($areas as $area) {
				$results[] = [
					'name' => $area[0],
					'value' => 0,
				];
			}

			foreach ($questions as $key => $question) {
				$areaId = $question[1];
				$results[$areaId - 1]['value'] += $rawResults[$key];
			}

			foreach ($results as &$area) {
				$area['percentage'] = percent($area['value'], 16);
			}
		}

		return $results;
	}

	// Test 21 - Attenzione - Iperattività
	private function calcDetailedAttenzioneIperattività() {
		$requiredTest = $this->test->requiredTest
			->setStudentId($this->studentId);

		if ($requiredTest->completed) {
			$results = [
				'Iperattività' => 0,
				'Distraibilità' => 0
			];

			if ($requiredTest->completed) {
				foreach ($requiredTest->rawResults as $key => $result) {
					if ($key % 2) {
						$results['Iperattività'] += $result;
					} else {
						$results['Distraibilità'] += $result;
					}
				}
			}

			return $results;
		} else {
			return null;
		}
	}

	// Test 46: Temperamento
	private function calcTemperamento() {
		$results = [];
		$legacySections = test_config($this->testId, 'sections');

		for ($i = 1; $i < 6; $i++) {
			$requiredTestId = \App\Legacy\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$this->test->sectionId, $i]);
			$requiredTest = (new Test($requiredTestId))->setStudentId($this->studentId);

			if ($requiredTest->completed) {
				$results[] = [
					'name' => $legacySections[$i - 1],
					'value' => round($requiredTest->percentage / 100 * 6),
					'percentage' => $requiredTest->percentage
				];
			}
		}

		return empty($results) ? null : $results;
	}

	// Test 48
	private function calcStileAttributivo() {
		$legacyTest = $this->test->requiredTest->setStudentId($this->studentId);

		if ($legacyTest->completed) {
			$results = [];
			$formattedResults = [];
			$styles = test_config($this->testId, 'styles');

			foreach ($styles as $style) {
				$results[$style] = 0;
			}

			foreach ($legacyTest->rawResults as $key => $value) {
				$style = $styles[$value - 1];

				$results[$style]++;
			}

			foreach ($results as $style => $result) {
				$formattedResults[] = [
					'name' => $style,
					'value' => $result,
					'percentage' => percent($result, 8),
				];
			}

			return $formattedResults;
		} else {
			return null;
		}
	}

	// Test 63 - Stili di scrittura
	private function calcDetailedScrivereStili() {
		$results = [];
		$max = 5;
		$legacyTest = $this->test->requiredTest->setStudentId($this->studentId);
		$legacyTestConfig = test_config($this->test->id, 'types');

		foreach ($legacyTest->rawResults as $id => $result) {
			$results[] = [
				'name' => $legacyTestConfig[$id],
				'value' => $result - 1,
				'percentage' => round(($result - 1) / $max * 100),
			];
		}

		return $results;
	}

	// Test 92 - I miei interessi
	private function calcDetailedInteressi() {
		$results = [];
		$rawResults = ($this->test->requiredTest)
			->setStudentId($this->studentId)
			->rawResults;
		$groups = test_config($this->testId, 'groups');

		if ($rawResults) {
			foreach ($groups as $groupId => $group) {
				$result = [
					'id' => $groupId,
					'name' => $group['name'],
					'value' => 0,
					'max' => count($group['questionIds']) * 3
				];

				foreach ($group['questionIds'] as $questionId) {
					$value = $rawResults[$questionId - 1] ?? 0;
					$result['value'] += $value ? $value - 1 : 0;
				}

				$results[] = $result;
			}
		}

		foreach ($results as &$result) {
			$result['percentage'] = round($result['value'] / $result['max'] * 100);
		}

		return $results;
	}

	// Test 101 - L'albero della vita
	private function calcDetailedAlberoVita() {
		$characters = test_config($this->testId, 'characters');
		$characterId = $this->rawResults[0] ?? null;

		return $characterId ? $characters[$characterId - 1] : null;
	}

	// Test 116 - La ruota delle emozioni
	private function calcDetailedRuotaEmozioni() {
		$testIds = [102, 115, $this->testId];
		$emotions = [];

		foreach ($testIds as $testId) {
			$result = (new Test($testId))
				->setStudentId($this->studentId)
				->rawResults ?? null;

			if ($result) {
				$emotions[] = [
					'name' => $result[0],
					'value' => $result[1],
					'percentage' => round($result[1] / 4 * 100),
				];
			}
		}

		return $emotions;
	}

	// default
	private function calcResult() {
		return $this->test->completed ? $this->test->percentage . '%' : null;
	}

	/*
	* OLD
	private function calcMotivazioneMappa() {
		// foreach ($studentResults as $key => $CondensedTestResult) {
		// 	if (!isset($results['values'][$key])) $results['values'][$key] = 0;
		// 	$results['values'][$key] += $CondensedTestResult;
		// }
	}

	private function calcInteressiRisultati() {
		$results = false;
		$maxValue = 18;
		$groups = test_config($this->testId, 'groups');
		$legacyTest = new Test(91);

		if ($legacyTest->rawResults) {
			$results = [];

			foreach ($groups as $groupId => $group) {
				$score = 0;

				foreach ($group['questionIds'] as $questionId) {
					$legacyTestScore = $legacyTest->rawResults[$questionId - 1] ?? 0;
					$score += ((int) $legacyTestScore) - 1;
				}

				$results[$groupId] = round($score / $maxValue * 100);
			}

			arsort($results);
		}

		return $results;
	}

	// parse the numeric result to a string
	/*static function getResult($gradeId, $this->testId) {
		$result = $this->getRawResult($gradeId, $this->testId)['values'];
		$result = $this->parseToString($testId, $result);

		return $result;
	}

	static function parseToString($testId, $value) {
		$result = false;

		if ($value) {
			switch ($testId) {
				case 17:
					// attenzione - questionario
					$names = ['Bassissima', 'Bassa', 'Media', 'Alta', 'Altissima'];
					$score = round($value / 25);
					$result = $names[$score] . ' (' . $value . '%)';
					break;
				default:
					$result = $value . '%';
			}
		}

		return $result;
	}

	// calculate the result of section of for a specific student
	static function getRawResult(int $testId, int $this->studentId = null) {
		switch ($testId) {
			case 1:
				$result = $this->calcProblemiAutovalutazione($studentId);
				break;
			case 16:
				$result = $this->calcAttenzioneAutovalutazione($studentId);
				break;
			case 17:
				$result = $this->calcAttenzioneQuestionario($studentId);
				break;
			default:
				$result = false;
		}

		return $result;
	}

	static private function calcResults($studentId, $testId, $resultsNames, $max) {
		$results = false;
		$resultsRaw = \App\Legacy\LegacyDB::find('result FROM ' . TestResult::TABLE . ' WHERE testID = ? AND userID = ? AND completed=1', [$testId, $studentId]);

		if ($resultsRaw) {
			$resultsRaw = explode(',', $resultsRaw);

			foreach ($resultsRaw as $resultId => $resultValue) {
				$resultName = $resultsNames[$resultId];
				$resultValue = round($resultValue / $max * 100);
				$results[$resultName] = $resultValue;
			}
		}

		return $results;
	}

	// risolvere problemi
	static private function calcProblemiAutovalutazione($studentId) {
		$testId = 1;
		$max = 5;
		$resultsNames = [
			'Gestione delle emozioni',
			'Relazioni con gli altri',
			'Studio',
			'Ordine pratico',
			'Gestione del tempo',
			'Organizzazione',
			'Impegno e perseveranza',
			'Concentrazione',
			'Salute',
		];

		$results = $this->calcResults($studentId, $testId, $resultsNames, $max);

		return $results;
	}

	// attenzione
	static private function calcAttenzioneAutovalutazione($studentId) {
		$testId = 16;
		$max = 4;
		$resultsNames = [
			'Mi accorgo quando mi distraggo',
			'So che cosa mi distrae',
			'Riesco a recuperare l’attenzione',
			'So mantenere l’attenzione per il tempo necessario',
			'Ho una mia strategia per evitare di distrarmi',
			'Riesco a svolgere diverse attività nello stesso tempo'
		];

		$results = $this->calcResults($studentId, $testId, $resultsNames, $max);

		return $results;
	}

	static private function calcAttenzioneQuestionario($studentId) {
		$max = 3 * 9;
		$testId = 17;
		$results = [];
		$resultsNames = ['Perdita di attenzione', 'Iperattività'];

		$resultsRaw = \App\Legacy\LegacyDB::find('result FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$studentId, $testId]);

		if ($resultsRaw) {
			$resultsRaw = explode(',', $resultsRaw);

			foreach ($resultsRaw as $resultsId => $resultsValue) {
				$resultsName = $resultsNames[$resultsId % 2];

				if (!isset($results[$resultsName])) $results[$resultsName] = 0;

				$results[$resultsName] += $resultsValue;
			}

			foreach ($results as $resultsName => $resultsValue) {
				$results[$resultsName] = round($resultsValue / $max * 100);
			}
		} else $results = false;

		return $results;
	}*/
}
