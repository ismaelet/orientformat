<?php

namespace LegacyModels\Reviews;

use LegacyModels\Model;
use LegacyModels\User\Student;

/**
 * @property int studentId
 * @property int reviewId
 */
class ReviewResult extends Model {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = 'review_results';

	/**
	 * @param array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = [];

	/**
	 * Get the associated student
	 */
	public function student() {
		return $this->studentId ? Student::find($this->studentId) : null;
	}

	/**
	 * Get the associated review
	 */
	public function review() {
		return $this->reviewId ? Review::find($this->reviewId) : null;
	}

	/**
	 * Parse the results from string to JSON
	 * 
	 * @param bool $forTeacher if set, filters out the questions not meant to be shown to teachers and changes the text of the question
	 */
	public function parseResults(bool $forTeacher = true) {
		$results = [];
		$structuredResults = $this->structuredResults();

		foreach ($structuredResults as $questionKey => $answers) {
			$questionId = \App\Legacy\LegacyDB::find("id FROM " . ReviewQuestion::table() . " WHERE full_slug = ? AND (reviewIds = '' OR FIND_IN_SET(?, reviewIds))", [$questionKey, $this->reviewId]);

			if ($questionId) {
				$question = ReviewQuestion::find($questionId);

				if ($question->showToTeacher || !$forTeacher) {
					$questionText = $forTeacher ? $question->teacherText : $question->text;
					$questionText = '<strong>' . $questionKey . '.</strong> ' . $questionText;
					$results[$questionText] = $question->parseAnswers($answers);
				}
			}
		}

		return $results;
	}

	/**
	 * Explode the results in a structured array
	 * 
	 * @return array
	 */
	public function structuredResults(): array {
		$results = [];
		$stringResults = $this->results;
		$stringResults = explode(',', $stringResults);

		foreach ($stringResults as $resultItem) {
			$resultItem = explode('=', $resultItem);

			$questionMacroKey = $resultItem[0];
			$answer = $resultItem[1] ?? false;

			if (strpos($questionMacroKey, '_')) {
				$questionMacroKey = explode('_', $questionMacroKey);
				$questionKey = $questionMacroKey[0];
				$answerKey = $questionMacroKey[1];

				$results[$questionKey][$answerKey] = $answer;
			} else {
				$results[$questionMacroKey] = $answer;
			}
		}

		return $results;
	}
}
