<?php

namespace Student;

use DB;
use Review\Area;
use Review\Question;

class Questionnaire {
	const TABLE = 'review_results';

	private static $platformResults = [];

	private $data = [];
	private $row;

	public $id = null;
	public $reviewId;

	function __construct($id) {
		if ($row = DB::row('* FROM ' . self::TABLE . ' WHERE id = ?', [$id])) {
			$this->id = $id;
			$this->row = $row['results'];
			$this->reviewId = $row['reviewId'];
		}
	}

	function __get($name) {
		switch ($name) {
			case 'areas':
				return $this->data['areas'] = $this->getAreas();
			case 'results':
				return $this->data['results'] = $this->getResults();
			case 'numericResults':
				return $this->data['numericResults'] = $this->getNumericResults();
			case 'rawResults':
				return $this->data['rawResults'] = $this->getRawResults();
			case 'choice':
				return $this->data['choice'] = $this->getChoice();
			case 'platformResults':
				return $this->data['platformResults'] = self::getPlatformResults();
		}
	}

	/*
	* GET properties
	*/
	// get the student choice
	private function getChoice() {
		$choiceRawResults = [];
		$compactChoice = [];
		$allRawResults = $this->rawResults ?? null;
		$results = $this->results['s2d2'] ?? null;

		if ($results) {
			for ($i = 1; $i <= 4; $i++) {
				$choiceRawResults[] = $allRawResults['s2d2_' . $i] ?? null;
			}

			$preferredChoices = array_keys($choiceRawResults, max($choiceRawResults));

			foreach ($preferredChoices as $preferredChoiceKey) {
				$compactChoice = array_merge($compactChoice, array_slice($results, $preferredChoiceKey, 1));
			}
		}

		return $compactChoice;
	}

	/*
	* Structure raw results
	*/
	private function getRawResults() {
		$results = [];
		$rawResults = $this->row;
		$rawResults = explode(',', $rawResults);

		foreach ($rawResults as $result) {
			$result = explode('=', $result);
			$results[$result[0]] = $result[1] ?? false;
		}

		return $results;
	}

	/*
	* Get the review areas
	*/
	private function getAreas() {
		$areas = [];
		$areaIds = explode(',', DB::find('areas FROM reviews WHERE id=?', [$this->reviewId]));

		foreach ($areaIds as $areaId) {
			$areas[] = new Area($areaId, $this->reviewId);
		}

		return $areas;
	}

	/*
	* Results of a specific question
	*/
	private function getQuestionResults($question) {
		$result = null;

		if ($question->type == 'grid' && count($question->rows) == 1) {
			// grid with a single row
			$resultValue = $this->rawResults[$question->fullSlug] ?? null;
			if ($resultValue) $result = $question->answers[$resultValue - 1];
		} else if ($question->type == 'grid' && $question->grouppedBy == 'rows') {
			// grid with multiple rows, results groupped by rows
			$result = [];
			foreach ($question->rows as $resultId => $_looping) {
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[$question->rows[$resultId]['title']] = $question->answers[$resultValue - 1];
			}
		} else if ($question->type == 'grid') {
			// grid with results groupped by columns
			$result = [];
			foreach ($question->gridHeader as $resultId => $_looping) {
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[$question->gridHeader[$resultId]] = $question->answers[$resultValue - 1];
			}
		} else if ($question->type == 'list' && !$question->multiple) {
			// list with only one result
			$resultValue = $this->rawResults[$question->fullSlug] ?? null;
			if ($resultValue) $result = $question->answers[$resultValue - 1];
		} else if ($question->type == 'list') {
			// list with multiple possible results
			$result = [];
			foreach ($question->rows as $resultId => $_looping) {
				$question->fullSlug . '<br>';
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[] = $question->answers[$resultValue - 1];
			}
		}

		return $result;
	}

	/*
	* Numeric results of a specific question
	*/
	private function getNumericQuestionResults($question) {
		$result = null;

		if ($question->type == 'grid' && count($question->rows) == 1) {
			// grid with a single row
			$resultValue = $this->rawResults[$question->fullSlug] ?? null;
			if ($resultValue) $result = $question->answers[$resultValue - 1];
		} else if ($question->type == 'grid' && $question->grouppedBy == 'rows') {
			// grid with multiple rows, results groupped by rows
			$result = [];
			foreach ($question->rows as $resultId => $_looping) {
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[$resultId + 1] = $resultValue;
			}
		} else if ($question->type == 'grid') {
			// grid with results groupped by columns
			$result = [];
			foreach ($question->gridHeader as $resultId => $_looping) {
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[$resultId + 1] = $resultValue;
			}
		} else if ($question->type == 'list' && !$question->multiple) {
			// list with only one result
			$resultValue = $this->rawResults[$question->fullSlug] ?? null;
			if ($resultValue) $result = $resultValue;
		} else if ($question->type == 'list') {
			// list with multiple possible results
			$result = [];
			foreach ($question->rows as $resultId => $_looping) {
				$question->fullSlug . '<br>';
				$resultValue = $this->rawResults[$question->fullSlug . '_' . ($resultId + 1)] ?? null;
				if ($resultValue) $result[] = $question->answers[$resultValue - 1];
			}
		}

		return $result;
	}

	/*
	* All the results
	*/
	public function getResults() {
		$results = [];


		foreach ($this->areas as $area) {
			foreach ($area->questions as $question) {
				$questionResult = $this->getQuestionResults($question);

				if (!empty($questionResult)) $results[$question->fullSlug] = $questionResult;
			}
		}

		return $results;
	}

	/*
	* All the numeric results
	*/
	public function getNumericResults() {
		$results = [];

		foreach ($this->areas as $area) {
			foreach ($area->questions as $question) {
				$questionResult = $this->getNumericQuestionResults($question);

				if (is_array($questionResult)) {
					foreach ($questionResult as $subQuestionId => $questionSubResult) {
						$results[$question->fullSlug . '_' . $subQuestionId] = $questionSubResult ?: 0;
					}
				} else {
					$results[$question->fullSlug] = $questionResult ?: 0;
				}
			}
		}

		return $results;
	}

	/*
	* Averages
	*/
	static private function getPlatformResults() {
		$results = [];

		// prepare all the results
		$resultRows = DB::select('id FROM review_results');

		while ($resultRow = $resultRows->fetch_assoc()) {
			$profile = new self($resultRow['id']);
			$results[] = $profile->results;
		}

		return self::$platformResults = $results;
	}

	static public function getAverages() {
		$averages = [];

		// calculate the average for each question
		$questions = DB::select('id FROM review_questions WHERE average=1');

		while ($questionRow = $questions->fetch_assoc()) {
			$averageValues = null;
			$average = 0;
			$question = new Question($questionRow['id']);
			$average = DB::find('results FROM averages_surveys WHERE questionId=? AND time > NOW() - INTERVAL 1 WEEK', [$question->id]);

			// when the result is an array
			if (strpos($average, ',')) {
				$averagesRaw = explode(',', $average);
				$average = [];

				foreach ($averagesRaw as $averageRaw) {
					$averageRaw = explode('=', $averageRaw);
					$average[$averageRaw[0]] = $averageRaw[1];
				}
			}

			// when it isn't present the precalculated result
			if (!$average) {
				$resultCount = 0;
				$platformResults = self::$platformResults ?: self::getPlatformResults();

				foreach ($platformResults as $result) {
					$resultValues = $result[$question->fullSlug] ?? false;

					if ($resultValues !== false) {
						$resultCount++;

						if (is_array($resultValues)) {
							if ($averageValues === null) $averageValues = [];

							foreach ($resultValues as $resultTitle => $resultValue) {
								if (!isset($averageValues[$resultTitle])) $averageValues[$resultTitle] = 0;
								$averageValues[$resultTitle] += $resultValue;
							}
						} else {
							if ($averageValues === null) $averageValues = 0;
							$averageValues += $resultValues;
						}
					}
				}

				if (is_array($averageValues)) {
					$average = [];
					$averageSql = [];

					foreach ($averageValues as $resultTitle => $resultValue) {
						$average[$resultTitle] = format($resultValue / $resultCount);
						$averageSql[] = $resultTitle . '=' . format($resultValue / $resultCount);
					}

					$averageSql = implode(',', $averageSql);
				} else {
					$average = $averageSql = format($averageValues / $resultCount);
				}

				DB::delete('averages_surveys WHERE questionId=?', [$question->id]);
				DB::add('averages_surveys (questionId, results)', [$question->id, $averageSql]);
			}

			$averages[$question->fullSlug] = $average;
		}

		return $averages;
	}

	/*
	* Entry management
	*/
	public static function generateLastCompleted(int $studentId) {
		$questionnaireId = DB::find('id FROM ' . self::TABLE . ' WHERE studentId = ? ORDER BY reviewId DESC', [$studentId]);

		return new self($questionnaireId);
	}
}
