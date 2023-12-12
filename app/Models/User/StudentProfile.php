<?php

namespace app\Models\User;

use app\Models\OldModel;
use DB;

class StudentProfile extends OldModel {
	/**
	 * Database Model constants
	 */
	protected const TABLE = 'student_profiles';

	/**
	 * Static get methods
	 */


	/**
	 * Dynamic get methods
	 */
	public function dynamicChoice() {
		$mappedChoiches = [];
		$relevantKeys = ['s2d2_1', 's2d2_2', 's2d2_3', 's2d2_4'];
		$intensities = ['Lo esclude', 'Lo sta valutando', 'Ne è quasi sicuro/a', 'Ne è sicuro/a'];
		$choices = explode(',', DB::find('`rows` FROM review_questions WHERE id = 2'));

		$answers = DB::find('results FROM review_results WHERE studentId = ? ORDER BY reviewId DESC', [$this->id]);

		if ($answers) {
			$answers = explode(',', $answers);

			foreach ($answers as $answer) {
				if (strpos($answer, '=')) {
					$answer = explode('=', $answer);
					$answerKey = $answer[0];
					$answerValue = $answer[1] ?? null;
					$choiceKey = array_search($answerKey, $relevantKeys);

					if ($choiceKey !== false) {
						$mappedChoiches[$choices[$choiceKey]] = $answerValue;
					}
				}
			}
		}

		if (!empty($mappedChoiches)) {
			$choiceArea = array_keys($mappedChoiches, max($mappedChoiches))[0];
			$choiceIntensity = $intensities[max($mappedChoiches) - 1];
			$choice =
				[
					'primary_choice_area' => $choiceArea,
					'primary_choice_intensity' => $choiceIntensity,
				];

			self::post($choice);

			return $choice;
		}
	}
}
