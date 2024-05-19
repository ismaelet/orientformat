<?php

use \Legacy\Activity\Result\SectionResult;
use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Section;

$schoolClass = schoolClass();
$testCount = $schoolClass->studentCount ? \Legacy\System\Classes\LegacyDB::count('results_permanent WHERE studentId IN (' . $schoolClass->studentIdsString . ')') : 0;

$advicesCount = $schoolClass->studentCount ? \Legacy\System\Classes\LegacyDB::count('advices WHERE userID IN (' . $schoolClass->studentIdsString . ')') : 0;
$advicesPercentage = $schoolClass->studentCount ? round($advicesCount / $schoolClass->studentCount * 100) : 0;

// data
$sectionsCount = \Legacy\System\Classes\LegacyDB::count(Section::TABLE . ' WHERE isStandard = 1 AND active = 1 AND FIND_IN_SET(?, years)', [$schoolClass->fullGrade]);
$progressCount = $schoolClass->studentCount ? \Legacy\System\Classes\LegacyDB::count(SectionResult::TABLE . ' WHERE completed = 1 AND ' . SectionResult::USER_INDEX . ' IN (' . $schoolClass->activeStudentIdsString . ') AND ' . SectionResult::SECTION_INDEX . ' IN (SELECT ' . Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE isStandard = 1 AND active = 1 AND FIND_IN_SET(?, years))', [$schoolClass->fullGrade]) : 0;

$maxProgressCount = $sectionsCount * $schoolClass->activeStudentCount;
$progressPercent = $maxProgressCount ? round($progressCount / $maxProgressCount * 100) : 0;

// fetch students
$students = $schoolClass->studentCount ? \Legacy\System\Classes\LegacyDB::select('* FROM users WHERE id IN (' . $schoolClass->studentIdsString . ') ORDER BY lastName ASC, firstName ASC, id DESC') : null;

// feed
$maxFeedCount = round(13 / 19 * $schoolClass->studentCount);
$feed = [];
$feedEntriesData = $schoolClass->studentCount ? \Legacy\System\Classes\LegacyDB::select(TestResult::USER_INDEX . ', ' . TestResult::TEST_INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (' . $schoolClass->studentIdsString . ') ORDER BY time DESC LIMIT ' . $maxFeedCount) : null;
$feedEntriesData = $feedEntriesData && $feedEntriesData->num_rows ? $feedEntriesData : null;

if ($feedEntriesData) {
	while ($feedEntryData = $feedEntriesData->fetch_assoc()) {
		$feedEntry = [];
		$feedStudent = new \Legacy\UserSystem\Student($feedEntryData[TestResult::USER_INDEX]);
		$feedTest = new \Legacy\Activity\Test($feedEntryData[TestResult::TEST_INDEX]);
		$feedEntry['studentName'] = $feedStudent->fullName;
		$feedEntry['text'] = 'ha completato l\'attività <strong>' . $feedTest->fullTitle . '</strong>';

		$feed[] = $feedEntry;
	}
}
