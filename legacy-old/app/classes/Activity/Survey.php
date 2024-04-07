<?php

namespace Activity;

use DatabaseObject;
use DB;

class Survey {

	use DatabaseObject;

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
		$res = DB::select('text, positive FROM surveys_questions WHERE surveyId = ?', [$this->id]);

		while ($row = $res->fetch_assoc()) {
			$questions[] = [$row['text'], $row['positive']];
		}

		return $questions;
	}

	private function getQuestionCount() {
		return count($this->questions);
	}
}
