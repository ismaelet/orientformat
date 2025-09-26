<?php

namespace Legacy\Activity;

use Illuminate\Support\Facades\Auth;
use \Legacy\Activity\Result\AdditionalTestResult;
use \Legacy\Activity\Result\Handler\StudentTestResult;
use \Legacy\Activity\Result\TestResult;

/**
 * Test
 * 
 * @property string title
 * @property string url
 * @property string template
 * @property string clientUrl
 * 
 * @property int sectionId
 * @property object section
 * 
 * @property int areaId
 * @property object area
 * 
 * @property int resultId
 * @property object result
 * @property bool hasResult
 * @property bool completed
 * @property bool everCompleted
 * @property int additionalResultId
 * @property object additionalResult
 * @property array additionalPrimaryResult
 * @property array additionalSecondaryResult
 * 
 * @property int nextTestId
 * @property object nextTest
 * @property bool hasNextTest
 * 
 * @property int requiredTestId
 * @property object requiredTest
 * @property bool hasRequiredTest
 * 
 * @property int followUpTestId
 * @property object followUpTest
 * @property bool hasFollowUpTest
 * 
 * @property int recapTestId
 * @property object recapTest
 * @property bool hasRecapTest
 * 
 * @property int surveyId
 * @property object survey
 */

class Test {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'tests';
	public const INDEX = 'id';
	public const SECTION_INDEX = 'sectionId';
	public const AREA_INDEX = 'areaId';

	/**
	 * Get methods
	 */
	private function getStudentId() {
		return watchedStudentId();
	}

	private function getTitle() {
		return __('tests.' . $this->id);
	}

	private function getSummary() {
		return __('tests.summary-' . $this->id);
	}

	private function getDescription() {
		return __('tests.description-' . $this->id);
	}

	private function getUrl() {
		return '/activities/tests/' . $this->id;
	}

	private function getClientUrl() {
		return client_url($this->url);
	}

	private function getFilePath() {
		return $this->area->slug . '/' . $this->section->slug . '/' . $this->slug;
	}

	private function getFullTitle() {
		return $this->id ? $this->section->title . ' - ' . $this->title : null;
	}

	private function getResultId() {
		return \App\Legacy\LegacyDB::find(TestResult::INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$this->studentId, $this->id]);
	}

	private function getResult() {
		return $this->hasResult ? new TestResult($this->resultId) : null;
	}

	private function getHasResult() {
		return (bool) $this->resultId;
	}

	private function getRawResults() {
		return $this->hasResult ? $this->result->rawResults : null;
	}

	private function getDetailedResult() {
		return (new StudentTestResult($this->id))
			->detailedResult;
	}

	private function getCompleted() {
		return $this->hasResult ? $this->result->completed : false;
	}

	private function getEverCompleted() {
		return \App\Legacy\LegacyDB::exists('results_permanent WHERE studentId = ? AND testId = ? ', [\Illuminate\Support\Facades\Auth::id(), $this->id]);
	}

	private function getPercentage() {
		return $this->result ? $this->result->percentage : 0;
	}

	private function getAdditionalResultId() {
		return \App\Legacy\LegacyDB::find(AdditionalTestResult::INDEX . ' FROM ' . AdditionalTestResult::TABLE . ' WHERE ' . AdditionalTestResult::USER_INDEX . ' = ? AND ' . AdditionalTestResult::TEST_INDEX . ' = ?', [\Illuminate\Support\Facades\Auth::id(), $this->id]);
	}

	private function getAdditionalResult() {
		return $this->additionalResultId ? new AdditionalTestResult($this->additionalResultId) : null;
	}

	private function getAdditionalPrimaryResult() {
		return $this->additionalResult ? $this->additionalResult->primaryResults : null;
	}

	private function getAdditionalSecondaryResult() {
		return $this->additionalResult ? $this->additionalResult->secondaryResults : null;
	}

	private function getSection() {
		return new Section($this->sectionId);
	}

	private function getArea() {
		return $this->section->area;
	}

	private function getNextTestId() {
		return \App\Legacy\LegacyDB::find(self::INDEX . ' FROM ' . self::TABLE . ' WHERE ' . self::SECTION_INDEX . ' = ? AND step > ? AND active = 1 ORDER BY step ASC', [$this->sectionId, $this->step]);
	}

	private function getNextlegacy_test() {
		return $this->hasNextTest ? new Test($this->nextTestId) : null;
	}

	private function getHasNextlegacy_test() {
		return (bool) $this->nextTestId;
	}

	private function getRequiredlegacy_test() {
		return new Test($this->requiredTestId);
	}

	private function getHasRequiredlegacy_test() {
		return (bool) $this->requiredTestId;
	}

	private function getFollowUpTestId() {
		return $this->databaseEntry['followUpTestId'] ?: \App\Legacy\LegacyDB::find(self::INDEX . ' FROM ' . self::TABLE . ' WHERE requiredTestId = ?', [$this->id]);
	}

	private function getFollowUplegacy_test() {
		return new Test($this->followUpTestId);
	}

	private function getHasFollowUplegacy_test() {
		return (bool) $this->followUpTestId;
	}

	private function getRecaplegacy_test() {
		return new Test($this->recapTestId);
	}

	private function getHasRecaplegacy_test() {
		return (bool) $this->recapTestId;
	}

	private function getSurvey() {
		return new Survey($this->surveyId);
	}

	/**
	 * Set methods
	 */
	public function setStudentId(int $studentId) {
		$this->data['studentId'] = $studentId;

		return $this;
	}

	/**
	 * Misc methods
	 */
	// save the test result
	public function saveResult($results, $percentage, $completed, $speed) {
		TestResult::new([
			'studentId' => Auth::id(),
			'testId' => $this->id,
			'results' => $results,
			'percentage' => $percentage,
			'completed' => $completed,
			'speed' => $speed,
		]);

		// update section progress
		$this->section->updateProgress();
	}

	// advance to the next test
	public function advance(bool $reloadPage = false) {
		// redirect
		if ($reloadPage) {
			redirect_old($this->url);
		} else if ($this->hasRecapTest && $this->nextTest->completed) {
			redirect_old($this->recapTest->url);
		} else if ($this->hasFollowUpTest) {
			redirect_old($this->followUpTest->url);
		} else {
			redirect_old($this->section->url);
		}
	}

	public function redo() {
		\App\Legacy\LegacyDB::delete(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [\Illuminate\Support\Facades\Auth::id(), $this->id]);
		\App\Legacy\LegacyDB::delete(AdditionalTestResult::TABLE . ' WHERE ' . AdditionalTestResult::USER_INDEX . ' = ? AND ' . AdditionalTestResult::TEST_INDEX . ' = ?', [\Illuminate\Support\Facades\Auth::id(), $this->id]);
		\App\Legacy\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [userId(), $this->id]);

		// update section progress
		$this->section->updateProgress();

		redirect_old($this->url);
	}
}
