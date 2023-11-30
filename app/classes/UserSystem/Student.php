<?php

namespace UserSystem;

use app\Models\User\StudentProfile;
use DatabaseObject;
use DB;
use SchoolSystem\School;
use SchoolSystem\SchoolClass;
use User;
use UserSystem\Student\Advice;

/**
 * Student class
 * 
 * @property object user
 * 
 * @property string invertedFullName
 * 
 * @property int schoolClassId
 * @property object schoolClass
 * @property object school
 * @property object grade
 * @property bool isInMiddleschool
 * @property bool isInHighschool
 * 
 * @property object profile
 */
class Student {

	use DatabaseObject;

	public const TABLE = 'students';
	public const INDEX = 'userId';
	public const SCHOOL_CLASS_INDEX = 'schoolClassId';

	/**
	 * Get methods
	 */
	private function getId() {
		return $this->{self::INDEX};
	}

	private function getUser() {
		return new User($this->userId);
	}

	private function getUsername() {
		return $this->user->username;
	}

	private function getFirstName() {
		return $this->user->firstName;
	}

	private function getLastName() {
		return $this->user->lastName;
	}

	private function getFullName() {
		return $this->user->fullName;
	}

	private function getInvertedFullName() {
		return $this->user->invertedFullName;
	}

	private function getSchoolClass() {
		return $this->schoolClassId ? new SchoolClass($this->schoolClassId) : null;
	}

	private function getSchool() {
		return new School($this->schoolClass->schoolId);
	}

	private function getGrade() {
		return $this->schoolClass ? $this->schoolClass->grade : null;
	}

	private function getIsInMiddleschool() {
		return $this->grade && $this->grade->isMiddleSchool;
	}

	private function getIsInHighschool() {
		return $this->grade && $this->grade->isHighSchool;
	}

	private function getHasCompletedEndReview() {
		return DB::exists('survey_end WHERE userID = ?', [$this->id]);
	}

	private function getStartReviewId() {
		return DB::find('id FROM review_results WHERE studentId = ? AND reviewId IN (1, 2) ORDER BY reviewId DESC', [$this->id]);
	}
	private function getEndReviewId() {
		return DB::find('id FROM review_results WHERE studentId = ? AND reviewId = 3', [$this->id]);
	}

	private function getProfile() {
		return StudentProfile::newAdd($this->id);
	}

	private function getAdvicesString() {
		return $this->parseAdvices();
	}

	private function getAdvices() {
		$advices = false;

		$advicesData = DB::find('advices FROM advices WHERE userID=?', [$this->id]);

		if ($advicesData) {
			$advices = [];
			$advicesData = explode(',', $advicesData);

			foreach ($advicesData as $adviceId) {
				$advices[] = new Advice($adviceId);
			}
		}

		return $advices;
	}

	private function parseAdvices() {
		if ($this->advices) {
			$advicesStr = [];

			foreach ($this->advices as $key => $advice) {
				$advicesStr[] = $key + 1 . '. ' . $advice->name;
			}

			$advicesStr = implode('<br>', $advicesStr);
		} else {
			$advicesStr = '';
		}

		return $advicesStr;
	}

	private function getChoices() {
		$choices = [];

		$profile = $this->profile;

		if ($profile->id) {

			$surveyResults = $profile->results;
			$genericResults = $surveyResults['s2d2'] ?? false;

			if ($genericResults) {
				foreach ($genericResults as $surveyResultTitle => $surveyResult) {
					$choices[$surveyResultTitle] = $surveyResult;
				}
			}
		}

		return $choices;
	}

	private function getSpecificChoices() {
		$choices = [];

		$answerIds = ['Liceo' => 's2d3a', 'Istituto Tecnico' => 's2d3b', 'Istruzione e Formazione Professionale' => 's2d3c', 'Istituto Professionale (Istituto “Don Milani” e Istituto “I. De Carneri” Oxford)' => 's2d3d'];

		$profile = $this->profile;

		if ($profile->id) {

			$surveyResults = $profile->results;

			foreach ($answerIds as $answerTitle => $answerSlug) {
				$specificChoice = $surveyResults[$answerSlug] ?? null;
				$choice = $specificChoice && $specificChoice != 'Non ci ho ancora pensato' ? $specificChoice : null;
				if ($choice) $choices[$answerTitle] = $choice;
			}
		}

		return $choices;
	}

	private function getCombinedChoices() {
		$combinedChoices = [];
		$choices = $this->getChoices();
		$specificChoices = $this->getspecificChoices();

		foreach ($choices as $choiceTitle => $result) {
			$choice = $choiceTitle;
			if (isset($specificChoices[$choiceTitle])) $choice = $specificChoices[$choiceTitle];
			$combinedChoices[$choice] = $result;
		}

		return $combinedChoices;
	}

	/**
	 * Misc
	 */
	public function calcPersonalData() {
		if (!DB::exists('students_data WHERE studentId = ?', [$this->id])) {
			$tempData = [];
			$tempSurveryData = [];

			if ($tempSurvery = DB::find('results FROM review_results WHERE studentId = ? AND FIND_IN_SET (reviewId, "1,2")', [$this->id])) {
				foreach (explode(',', $tempSurvery) as $tempSurveryVal) {
					$tempSurveryVal = explode('=', $tempSurveryVal);
					$tempSurveryData[$tempSurveryVal[0]] = $tempSurveryVal[1] ?? false;
				}

				$tempData['gender'] = $tempSurveryData['s1d1'] ?? 9;
				$tempData['decided'] = $tempSurveryData['s2d1'] ?? 0;
				$newDegreeLevel = isset($tempSurveryData['s4d1_1']) && isset($tempSurveryData['s4d1_2']) ? max($tempSurveryData['s4d1_1'], $tempSurveryData['s4d1_2']) : 7;

				switch ($newDegreeLevel) {
					case 5:
						$oldDegreeLevel = 8;
						break;
					case 6:
					case 7:
						$oldDegreeLevel = 0;
						break;
					default:
						$oldDegreeLevel = $newDegreeLevel;
						break;
				}

				$tempData['degree'] = $oldDegreeLevel;
			}

			if (!empty($tempData)) {
				DB::add('students_data (studentId, gender, decided, degree)', [$this->id, $tempData['gender'], $tempData['decided'], $tempData['degree']]);
			}
		}
	}
}
