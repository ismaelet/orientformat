<?php

namespace App\Models\Reviews;

use App\Models\Model;

/**
 * @property string rows
 * @property string gridHeader
 */
class ReviewQuestion extends Model {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = 'review_questions';

	/**
	 * @param array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = ['showToTeacher'];

	/**
	 * Get subfields
	 */
	private function subfields() {
		return $this->rows ? explode(',', $this->rows) : null;
	}

	/**
	 * Get rows
	 */
	private function answers() {
		return explode(',', $this->gridHeader);
	}

	/**
	 * Parse answers
	 */
	public function parseAnswers($answerValues) {
		// multiple answers
		if (is_array($answerValues)) {
			$results = [];
			$choices = $this->subfields();

			foreach ($answerValues as $answerKey => $answer) {
				if ($this->type == 'grid') {
					if (!empty($choices[$answerKey - 1])) {
						$results[$choices[$answerKey - 1]] = $this->answers() ? $this->answers()[$answer - 1] : $answer;
					}
				} else {
					$results[$choices[$answerKey - 1]] = $this->answers() ? $this->answers()[$answer - 1] : $answer;
				}
			}

			return $results;
		} else {
			return $this->subfields() ? $this->subfields()[$answerValues - 1] : $answerValues;
		}
	}
}
