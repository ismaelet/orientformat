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
		if (!$this->id) {
			return null;
		}

		$answers = explode(',', $this->databaseEntry['answers']);

		return array_map(function ($answer) {
			return __(__($answer, [], 'en'));
		}, $answers);
	}

	private function getAnswerCount() {
		return count($this->answers);
	}

	private function getQuestions() {
		$questions = [];
		$res = \App\Legacy\LegacyDB::select('id, text, positive FROM surveys_questions WHERE surveyId = ?', [$this->id]);

		while ($row = $res->fetch_assoc()) {
			$questions[] = [__('surveys.' . $row['id']), $row['positive']];
		}

		return $questions;
	}

	private function getQuestionCount() {
		return count($this->questions);
	}
}
