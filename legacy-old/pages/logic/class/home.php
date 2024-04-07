<?php

use Activity\Result\SectionResult;
use Activity\Result\TestResult;
use Activity\Section;

$schoolClass = schoolClass();
$testCount = $schoolClass->studentCount ? DB::count('results_permanent WHERE studentId IN (' . $schoolClass->studentIdsString . ')') : 0;

$advicesCount = $schoolClass->studentCount ? DB::count('advices WHERE userID IN (' . $schoolClass->studentIdsString . ')') : 0;
$advicesPercentage = $schoolClass->studentCount ? round($advicesCount / $schoolClass->studentCount * 100) : 0;

// data
$sectionsCount = DB::count(Section::TABLE . ' WHERE isStandard = 1 AND active = 1 AND FIND_IN_SET(?, years)', [$schoolClass->fullGrade]);
$progressCount = $schoolClass->studentCount ? DB::count(SectionResult::TABLE . ' WHERE completed = 1 AND ' . SectionResult::USER_INDEX . ' IN (' . $schoolClass->activeStudentIdsString . ') AND ' . SectionResult::SECTION_INDEX . ' IN (SELECT ' . Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE isStandard = 1 AND active = 1 AND FIND_IN_SET(?, years))', [$schoolClass->fullGrade]) : 0;

$maxProgressCount = $sectionsCount * $schoolClass->activeStudentCount;
$progressPercent = $maxProgressCount ? round($progressCount / $maxProgressCount * 100) : 0;

// fetch students
$students = $schoolClass->studentCount ? DB::select('* FROM users WHERE id IN (' . $schoolClass->studentIdsString . ') ORDER BY lastName ASC, firstName ASC, id DESC') : null;

// feed
$maxFeedCount = round(13 / 19 * $schoolClass->studentCount);
$feed = [];
$feedEntriesData = $schoolClass->studentCount ? DB::select(TestResult::USER_INDEX . ', ' . TestResult::TEST_INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (' . $schoolClass->studentIdsString . ') ORDER BY time DESC LIMIT ' . $maxFeedCount) : null;
$feedEntriesData = $feedEntriesData && $feedEntriesData->num_rows ? $feedEntriesData : null;

if ($feedEntriesData) {
	while ($feedEntryData = $feedEntriesData->fetch_assoc()) {
		$feedEntry = [];
		$feedStudent = new UserSystem\Student($feedEntryData[TestResult::USER_INDEX]);
		$feedTest = new Activity\Test($feedEntryData[TestResult::TEST_INDEX]);
		$feedEntry['studentName'] = $feedStudent->fullName;
		$feedEntry['text'] = 'ha completato l\'attività <strong>' . $feedTest->fullTitle . '</strong>';

		$feed[] = $feedEntry;
	}
}
