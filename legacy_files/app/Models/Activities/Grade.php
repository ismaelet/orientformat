<?php

namespace LegacyModels\Activities;

use LegacyModels\Activities\Results\TestResult;
use LegacyModels\OldModel;
use DBOld;
use User;

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

		$testTable = Test::table();
		$testIndex = Test::indexName();
		$sectionTable = Section::table();
		$sectionIndex = Section::indexName();
		$sectionLinkedIndex = Test::linkedIndexName(Section::class);

		return $this->testIds = (\System\Classes\DBOld::execute(
			"SELECT $testTable.$testIndex
				FROM $testTable 
				INNER JOIN $sectionTable
				ON $testTable.$sectionLinkedIndex = $sectionTable.$sectionIndex
				WHERE FIND_IN_SET(?, grades) AND $testTable.active = 1 AND $sectionTable.active = 1",
			[$this->id()]
		))->extractResults() ?: [];
	}

	public function testCount() {
		return count($this->testIds());
	}

	public function completedTestIds(): array {
		if ($this->completedTestIds) return $this->completedTestIds;

		$testResultIndex = TestResult::indexName();
		$testResultTable = TestResult::table();
		$testResultUserIndex = TestResult::linkedIndexName(User::class);
		$testResultTestIndex = TestResult::linkedIndexName(Test::class);
		$gradeTestIds = implode(',', $this->testIds());

		return $this->completedTestIds = \System\Classes\DBOld::execute("SELECT $testResultIndex FROM $testResultTable WHERE $testResultUserIndex = ? AND FIND_IN_SET($testResultTestIndex, '$gradeTestIds')", [studentId()])->extractResults() ?: [];
	}

	public function completedTestCount() {
		return count($this->completedTestIds());
	}

	public function completedPercentage() {
		return percent($this->completedTestCount(), $this->testCount());
	}
}
