<?php

namespace Activity\Result\Handler;

use Activity\Test;
use DynamicProperties;
use SchoolSystem\SchoolClass;

/**
 * SchoolClassSectionResult class
 */
class SchoolClassTestResult {

	use DynamicProperties;

	private $testId;
	private $schoolClassId;

	/**
	 * Magic methods
	 */
	function __construct(int $testId, $schoolClassId = null, $filterBy = null, $range = []) {
		$this->testId = $testId;
		$this->schoolClassId = $schoolClassId;
	}

	public function getSchoolClass() {
		return new SchoolClass($this->schoolClassId);
	}

	public function getRawResult() {

		// otherwise and for class results or if the platform results are outdated, calculate the results
		switch ($this->testId) {
				// Ascoltare
			case 27:
				return $this->calcSurveyResults();
		}
	}

	public function calcSurveyResults() {
		$answers = [];
		$max = 4;
		$resultCount = 0;

		foreach ($this->getSchoolClass()->students as $student) {
			$test = (new Test($this->testId))->setStudentId($student->id);
			$requiredTest = ($test->requiredTest)->setStudentId($student->id);
			$survey = $requiredTest->survey;

			$questions = $survey->questions;

			if ($requiredTest->completed) {
				$resultCount++;

				foreach ($questions as $key => $question) {
					$value = $requiredTest->rawResults[$key] ?? 0;
					$question = $question[0];

					if (!isset($answers['values'][$question])) {
						$answers['values'][$question] = $value;
					} else {
						$answers['values'][$question] += $value;
					}
				}
			}
		}

		if ($resultCount > 0) {
			foreach ($answers['values'] as $key => $value) {
				$answers['values'][$key] = percent($value / $resultCount, $max);
			}
		}

		$answers['count'] = $resultCount;

		return $answers;
	}
}
