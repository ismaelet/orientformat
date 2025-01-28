<?php

use \Legacy\Activity\Result\Handler\StudentTestResult;

$legacyTest = test();
$isMiddleSchool = testId() == 92 ? true : false;
$results = (new StudentTestResult(testId(), watchedStudentId()))->detailedResult;

sort_subvalue_desc($results, 'percentage');

$interests = test_config($legacyTest->id, 'groups');
