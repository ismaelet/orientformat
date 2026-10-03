<?php

use \Legacy\Activity\Result\Handler\StudentTestResult;

$legacyTest = legacy_test();
$isMiddleSchool = testId() == 92;

$results = (new StudentTestResult(
    testId(),
    watchedStudentId()
))->detailedResult ?? [];

usort($results, function ($a, $b) {
    if (is_numeric($a['percentage']) && is_numeric($b['percentage'])) {
        return $b['percentage'] <=> $a['percentage'];
    }

    return strcmp($b['percentage'], $a['percentage']);
});

$interests = test_config($legacyTest->id, 'groups');
