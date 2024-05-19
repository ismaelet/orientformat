<?php

namespace LegacyModels\Activities;

use LegacyModels\Activities\Results\TestResult;
use LegacyModels\OldModel;
use \Legacy\System\Classes\User;

class Grade extends OldModel {
	/**
	 * Table name
	 */
	protected const TABLE = 'activities_grades';

	private $testIds;
	private $completedTestIds;

	/**
	 * Get methods
	 */
	public function testIds(): array {
		if ($this->testIds) return $this->testIds;

		$legacyTestTable = Test::table();
		$legacyTestIndex = Test::indexName();
		$legacySectionTable = Section::table();
		$legacySectionIndex = Section::indexName();
		$legacySectionLinkedIndex = Test::linkedIndexName(Section::class);

		return $this->testIds = (\Legacy\System\Classes\LegacyDB::execute(
			"SELECT $legacyTestTable.$legacyTestIndex
				FROM $legacyTestTable 
				INNER JOIN $legacySectionTable
				ON $legacyTestTable.$legacySectionLinkedIndex = $legacySectionTable.$legacySectionIndex
				WHERE FIND_IN_SET(?, grades) AND $legacyTestTable.active = 1 AND $legacySectionTable.active = 1",
			[$this->id()]
		))->extractResults() ?: [];
	}

	public function testCount() {
		return count($this->testIds());
	}

	public function completedTestIds(): array {
		if ($this->completedTestIds) return $this->completedTestIds;

		$legacyTestResultIndex = TestResult::indexName();
		$legacyTestResultTable = TestResult::table();
		$legacyTestResultUserIndex = TestResult::linkedIndexName(User::class);
		$legacyTestResultTestIndex = TestResult::linkedIndexName(Test::class);
		$gradeTestIds = implode(',', $this->testIds());

		return $this->completedTestIds = \Legacy\System\Classes\LegacyDB::execute("SELECT $legacyTestResultIndex FROM $legacyTestResultTable WHERE $legacyTestResultUserIndex = ? AND FIND_IN_SET($legacyTestResultTestIndex, '$gradeTestIds')", [\Illuminate\Support\Facades\Auth::id()])->extractResults() ?: [];
	}

	public function completedTestCount() {
		return count($this->completedTestIds());
	}

	public function completedPercentage() {
		return percent($this->completedTestCount(), $this->testCount());
	}
}
