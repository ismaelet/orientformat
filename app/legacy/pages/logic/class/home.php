<?php

use App\Models\Results\User\SectionResult;
use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Section;

$schoolClass = schoolClass();
$legacyTestCount = $schoolClass->studentCount ? \App\Legacy\LegacyDB::count('results_permanent WHERE studentId IN (' . $schoolClass->studentIdsString . ')') : 0;

$advicesCount = $schoolClass->studentCount ? \App\Legacy\LegacyDB::count('advices WHERE userID IN (' . $schoolClass->studentIdsString . ')') : 0;
$advicesPercentage = $schoolClass->studentCount ? round($advicesCount / $schoolClass->studentCount * 100) : 0;

// data
$legacySectionsCount = \App\Legacy\LegacyDB::count(Section::TABLE . ' WHERE isStandard = 1 AND active = 1 AND FIND_IN_SET(?, years)', [$schoolClass->fullGrade]);

$progressCount = SectionResult::where('completed', true)
	->whereIn('studentId', $schoolClass->activeStudentIds)
	->whereIn('sectionId', function ($query) use ($schoolClass) {
		$query->select('id')
			->from('activities_sections')
			->where('isStandard', true)
			->where('active', true)
			->whereRaw('FIND_IN_SET(?, years)', [$schoolClass->fullGrade]);
	})
	->count() ?: 0;

$maxProgressCount = $legacySectionsCount * $schoolClass->activeStudentCount;
$progressPercent = $maxProgressCount ? round($progressCount / $maxProgressCount * 100) : 0;

// fetch students
$students = $schoolClass->studentCount ? \App\Legacy\LegacyDB::select('* FROM users WHERE id IN (' . $schoolClass->studentIdsString . ') ORDER BY last_name ASC, first_name ASC, id DESC') : null;

// feed
$maxFeedCount = round(13 / 19 * $schoolClass->studentCount);
$feed = [];
$feedEntriesData = $schoolClass->studentCount ? \App\Legacy\LegacyDB::select(TestResult::USER_INDEX . ', ' . TestResult::TEST_INDEX . ' FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (' . $schoolClass->studentIdsString . ') ORDER BY time DESC LIMIT ' . $maxFeedCount) : null;
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
