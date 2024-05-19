<?php

global $grade;

$legacyTestCount = \App\Legacy\LegacyDB::count('results_permanent WHERE userID IN (SELECT userId FROM students WHERE classId = ?)', [$grade->id]);

$advicesCount = \App\Legacy\LegacyDB::count('advices WHERE userID IN (SELECT userId FROM students WHERE classId = ?)', [$grade->id]);
$advicesPercentage = round($advicesCount / $grade->studentCount * 100);

// fetch students
$students = \App\Legacy\LegacyDB::select('* FROM users WHERE id IN (SELECT userId FROM students WHERE classId = ?) ORDER BY time DESC, id DESC', [$grade->id]);

// feed
$feed = [];

$feedEntriesData = \App\Legacy\LegacyDB::select('userID, testID FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT userId FROM students WHERE classId = ?) GROUP BY userID ORDER BY time DESC LIMIT 10', [$grade->id]);

while ($feedEntryData = $feedEntriesData->fetch_assoc()) {
	$feedEntry = [];
	$feedStudent = new \Legacy\UserSystem\Student($feedEntryData['userID']);
	$feedTest = new \Legacy\Activity\Test($feedEntryData['testID']);
	$feedEntry['studentName'] = $feedStudent->fullName;
	$feedEntry['text'] = 'ha completato l\'attività <strong>' . $feedTest->fullTitle . '</strong>';

	$feed[] = $feedEntry;
}
