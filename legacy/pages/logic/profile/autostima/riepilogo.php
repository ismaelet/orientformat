<?php

use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Test;

$test = test();

// calculate the total
$tot = \System\Classes\DBOld::sum('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND id<?)', [watchedStudentId(), $test->section->id, $test->id]);
$compN = \System\Classes\DBOld::count(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND completed = 1 AND testID IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND id < ?)', [watchedStudentId(), $test->section->id, $test->id]);
$tot = $compN ? round($tot / $compN, 0) : 0;

// fetch the tests
$tests = [];
$maxHeight = 0;
$res = \System\Classes\DBOld::select(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ? AND step < ? ORDER BY step ASC', [$test->section->id, $test->step]);

while ($row = $res->fetch_assoc()) {
	$dependentTest = new Test($row[Test::INDEX]);

	if ($dependentTest->result && $dependentTest->result->percentage > $maxHeight) {
		$maxHeight = $dependentTest->result->percentage;
	}

	$tests[] = $dependentTest;
}

// reset a section
if (isset($_POST['reset-test'])) {
	(new Test($_POST['reset-test']))->redo();
}
