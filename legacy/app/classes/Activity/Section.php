<?php

namespace Legacy\Activity;

use Illuminate\Support\Facades\Auth;
use \Legacy\Activity\Result\SectionResult;
use \Legacy\Activity\Result\TestResult;
use LegacyModels\Activities\Results\CondensedSectionResult;
use LegacyModels\Activities\Section as SectionModel;
use \App\Legacy\User;

/**
 * Section class
 * 
 * @property string name
 * @property string slug
 * @property string filePath
 * @property string url
 * @property string clientUrl
 * @property int lastStep
 * 
 * @property array tests
 * @property int testCount
 * @property int completedTestCount
 * 
 * @property int resultId
 * @property object result
 * @property int lastCompletedStep
 * @property int progressPercentage
 * @property bool completed
 * 
 * @property int mainSectionId
 * @property object mainSection
 * @property bool isMainSection
 */
class Section {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'activities_sections';
	public const INDEX = 'id';
	public const AREA_INDEX = 'areaId';

	/*
	* Get methods
	*/
	private function getStudentId() {
		return Auth::id();
	}

	private function getTitle() {
		return $this->name;
	}

	private function getUrl() {
		return '/' . $this->area->slug . '/section?id=' . $this->id;
	}

	private function getClientUrl() {
		return client_url($this->url);
	}

	private function getFilePath() {
		return $this->area->slug . '/' . $this->slug;
	}

	private function getIcon() {
		return '/sections/section-' . $this->mainSectionId;
	}

	private function getArea() {
		return new Area($this->areaId);
	}

	private function getTests() {
		return rows_to_objects(\App\Legacy\LegacyDB::select(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ? AND active = 1', [$this->id]), Test::class);
	}

	private function getTestCount() {
		return count($this->tests);
	}

	private function getLastStep() {
		return \App\Legacy\LegacyDB::row('MAX(step) as maxStep FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ? AND active = 1', [$this->id])['maxStep'];
	}

	private function getLastCompletedStep() {
		return $this->result ? $this->result->lastCompletedStep : 0;
	}

	private function getResultId() {
		$resultId = \App\Legacy\LegacyDB::find(SectionResult::INDEX . ' FROM ' . SectionResult::TABLE . ' WHERE ' . SectionResult::SECTION_INDEX . ' = ?  AND ' . SectionResult::USER_INDEX . ' = ?', [$this->id, $this->studentId]);

		return $resultId ?: (SectionResult::new($this->id))->id;
	}

	private function getResult() {
		return $this->resultId ? new SectionResult($this->resultId) : null;
	}

	private function getCheckpointId() {
		return \App\Legacy\LegacyDB::find(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE active = 1 AND ' . Test::SECTION_INDEX . ' = ? AND ' . Test::INDEX . ' NOT IN (SELECT ' . TestResult::TEST_INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ?) ORDER BY step ASC', [$this->id, $this->studentId]);
	}

	private function getCheckpoint() {
		return new Test($this->checkpointId);
	}

	private function getCompletedTestCount() {
		return $this->result ? $this->result->completedTestCount : 0;
	}

	public function getProgressPercentage() {
		if ($this->isStandard) {
			return (int) \App\Legacy\LegacyDB::find('progressPercentage FROM results_sections WHERE studentId = ? AND sectionId = ?', [\Illuminate\Support\Facades\Auth::id(), $this->id]);
		} else {
			return 100;
		}
	}

	public function getCompleted() {
		if ($this->isStandard) {
			return \App\Legacy\LegacyDB::exists('results_sections WHERE studentId = ? AND sectionId = ? AND completed = 1', [$this->studentId, $this->id]);
		} else {
			return true;
		}
	}

	private function getMainSectionId() {
		return $this->databaseEntry['mainSectionId'] ?: $this->id;
	}

	private function getMainSection() {
		return $this->databaseEntry['mainSectionId'] ? new self($this->mainSectionId) : $this;
	}

	private function getIsMainSection() {
		return $this->mainSectionId == $this->id;
	}

	/**
	 * Set methods
	 */
	public function setStudentId(int $studentId) {
		$this->data['studentId'] = $studentId;

		return $this;
	}

	/**
	 * Update methods
	 */
	public function updateProgress() {
		if (!$this->resultId) {
			SectionResult::new($this->id);
		}

		// update section progress
		$completedTestCount = $this->calcCompletedTestCount();
		$lastCompletedStep = $this->calcLastCompletedStep();
		$percentage = round($completedTestCount / $this->testCount * 100);
		$completed = $lastCompletedStep >= $this->lastStep ? 1 : 0;

		\App\Legacy\LegacyDB::update(
			SectionResult::TABLE .
				' SET completedTestCount = ?, lastCompletedStep = ?, progressPercentage = ?, completed = ? 
				WHERE ' . SectionResult::USER_INDEX . ' = ? AND ' . SectionResult::SECTION_INDEX . ' = ?',

			[$completedTestCount, $lastCompletedStep, $percentage, $completed, \Illuminate\Support\Facades\Auth::id(), $this->id]
		);

		\App\Legacy\LegacyDB::delete(CondensedSectionResult::table() . ' WHERE ' . CondensedSectionResult::linkedIndexName(User::class) . ' = ? AND ' . CondensedSectionResult::linkedIndexName(SectionModel::class) . ' = ?', [\Illuminate\Support\Facades\Auth::id(), $this->id]);

		// update grade progress
		if (!is_teacher()) {
			Auth::user()->student->grade()->updateProgress();
		}

		// return this
		$this->resetDynamicProperties();

		return $this;
	}

	/**
	 * Calc methods
	 */
	private function calcCompletedTestCount() {
		return \App\Legacy\LegacyDB::count(
			TestResult::TABLE .
				' INNER JOIN ' . Test::TABLE .
				' ON ' . TestResult::TABLE . '.' . TestResult::TEST_INDEX . ' = ' . Test::TABLE . '.' . Test::INDEX . '
			WHERE ' . Test::SECTION_INDEX . ' = ? AND active = 1 AND ' . TestResult::USER_INDEX . ' = ?',

			[$this->id, \Illuminate\Support\Facades\Auth::id()]
		);
	}

	private function calcLastCompletedStep() {
		return \App\Legacy\LegacyDB::row(
			'MAX(step) as maxStep FROM ' .
				TestResult::TABLE .
				' INNER JOIN ' . Test::TABLE .
				' ON ' . TestResult::TABLE . '.' . TestResult::TEST_INDEX . ' = ' . Test::TABLE . '.' . Test::INDEX . '
			WHERE ' . Test::SECTION_INDEX . ' = ? AND active = 1 AND ' . TestResult::USER_INDEX . ' = ?',

			[$this->id, \Illuminate\Support\Facades\Auth::id()]
		)['maxStep'];
	}
}
