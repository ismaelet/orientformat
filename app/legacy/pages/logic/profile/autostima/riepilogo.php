<?php

use Illuminate\Support\Facades\DB;
use Legacy\Activity\Result\TestResult;
use Legacy\Activity\Test;

$legacyTest = legacy_test();

// calculate the total
$tot = DB::scalar('SELECT SUM(percentage) FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' IN (SELECT id FROM '.Test::TABLE.' WHERE sectionId = ? AND id<?)', [watchedStudentId(), $legacyTest->section->id, $legacyTest->id]);
$compN = DB::scalar('SELECT COUNT(*) FROM '.(TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND completed = 1 AND testID IN (SELECT id FROM '.Test::TABLE.' WHERE sectionId = ? AND id < ?)'), (array) ([watchedStudentId(), $legacyTest->section->id, $legacyTest->id]));
$tot = $compN ? round($tot / $compN, 0) : 0;

// fetch the tests
$legacyTests = [];
$maxHeight = 0;
$res = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.(Test::INDEX.' FROM '.Test::TABLE.' WHERE '.Test::SECTION_INDEX.' = ? AND step < ? ORDER BY step ASC'), (array) ([$legacyTest->section->id, $legacyTest->step])));

while ($row = array_shift($res)) {
    $dependentTest = new Test($row[Test::INDEX]);

    if ($dependentTest->result && $dependentTest->result->percentage > $maxHeight) {
        $maxHeight = $dependentTest->result->percentage;
    }

    $legacyTests[] = $dependentTest;
}

$maxHeight = $maxHeight ?: 100;
