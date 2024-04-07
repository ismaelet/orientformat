<?php

use Activity\Result\Handler\StudentTestResult;

$test = test();
$isMiddleSchool = testId() == 92 ? true : false;
$results = (new StudentTestResult(testId(), watchedStudentId()))->detailedResult;

sort_subvalue_desc($results, 'percentage');

$interests = test_config($test->id, 'groups');
