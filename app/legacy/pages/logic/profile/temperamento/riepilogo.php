<?php

use \Legacy\Activity\Test;

$legacyTest = legacy_test();
$test = legacy_test()->newTest();
$student = legacy_watched_student();
$helperClass = $test->helperClass();
$resultData = $helperClass::results(test: $test, student: $student);
$sections = $helperClass::getSections();
$results = [];

foreach ($sections as $step => $section) {
    $result = $resultData?->firstWhere('name', $section['name']);

    $results[$step] = collect([
        'name' => $section['name'],
        'percentage' => $result['percentage'] ?? 0,
        'test' => $test->dependent_tests()->where('step', $step)->first(),
        'tier' => $result['value'] ?? 0
    ]);
}

$results = collect($results);

// Reset test
if (isset($_POST['reset-test'])) {
    (new Test($_POST['reset-test']))->redo();
}
