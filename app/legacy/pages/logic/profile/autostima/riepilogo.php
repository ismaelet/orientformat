<?php

use App\Legacy\LegacyDB;
use Legacy\Activity\Result\TestResult;
use Legacy\Activity\Test;

$legacyTest = legacy_test();

// calculate the total
$tot = LegacyDB::sum('percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' IN (SELECT id FROM '.Test::TABLE.' WHERE sectionId = ? AND id<?)', [watchedStudentId(), $legacyTest->section->id, $legacyTest->id]);
$compN = LegacyDB::count(TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND completed = 1 AND testID IN (SELECT id FROM '.Test::TABLE.' WHERE sectionId = ? AND id < ?)', [watchedStudentId(), $legacyTest->section->id, $legacyTest->id]);
$tot = $compN ? round($tot / $compN, 0) : 0;

// fetch the tests
$legacyTests = [];
$maxHeight = 0;
$res = LegacyDB::select(Test::INDEX.' FROM '.Test::TABLE.' WHERE '.Test::SECTION_INDEX.' = ? AND step < ? ORDER BY step ASC', [$legacyTest->section->id, $legacyTest->step]);

while ($row = $res->fetch_assoc()) {
    $dependentTest = new Test($row[Test::INDEX]);

    if ($dependentTest->result && $dependentTest->result->percentage > $maxHeight) {
        $maxHeight = $dependentTest->result->percentage;
    }

    $legacyTests[] = $dependentTest;
}

$maxHeight = $maxHeight ?: 100;

// reset a section
if (isset($_POST['reset-test'])) {
    (new Test($_POST['reset-test']))->redo();
}
