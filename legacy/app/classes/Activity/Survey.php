<?php

namespace Legacy\Activity;

use DatabaseObject;
use LegacyDB;

class Survey {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'surveys';
	public const INDEX = 'id';

	/**
	 * Get methods
	 */
	private function getAnswers() {
		return $this->id ? explode(',', $this->databaseEntry['answers']) : null;
	}

	private function getAnswerCount() {
		return count($this->answers);
	}

	private function getQuestions() {
		$questions = [];
		$res = \Legacy\System\Classes\LegacyDB::select('text, positive FROM surveys_questions WHERE surveyId = ?', [$this->id]);

		while ($row = $res->fetch_assoc()) {
			$questions[] = [$row['text'], $row['positive']];
		}

		return $questions;
	}

	private function getQuestionCount() {
		return count($this->questions);
	}
}
