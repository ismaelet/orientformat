<?php

use \Legacy\Activity\Result\Handler\StudentTestResult;
use \Legacy\Activity\Test;
use \Legacy\Activity\Result\TestResult;
use \Legacy\UserSystem\Student;

$watch = $_GET['watch'] ?? false;

// interest data
$studentId = $_GET['student-id'] ?? \Illuminate\Support\Facades\Auth::id();
$student = new Student($studentId);
$highschool = $_GET['highschool'] ?? $student->isInHighschool;
$surveyTestId = $highschool ? 150 : 91;
$resultTestId = $highschool ? 151 : 92;
$interestId = $_GET['id'] ?? false;
$interests = test_config($resultTestId, 'groups');
$interest = $interests[$interestId];

$result = ((new StudentTestResult($resultTestId, $studentId))->detailedResult)[$interestId - 1]['percentage'] ?? false;
$survey = (new Test($surveyTestId))->setStudentId($studentId);

// questions
$questions = [];

for ($i = 1; $i <= count(test_config($surveyTestId, 'questions')); $i++) {
	$questions[] = __('tests.' . $surveyTestId . '-question-' . $i);
}

$questionIds = $interest['questionIds'];

bump($questions);

// schools
$schoolList = (include_once('-expands-interest/' . ($highschool ? 'universities' : 'schools') . '.php'))[$interestId] ?? false;

/*
* Form handling
*/
if (isset($_POST['edit'])) {
	$results = $survey->rawResults;

	foreach ($_POST['field'] as $resultId => $resultValue) {
		$results[$resultId] = $resultValue;
	}

	$results = implode(',', $results);

	\App\Legacy\LegacyDB::update('results SET result = ? WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$results, \Illuminate\Support\Facades\Auth::id(), $surveyTestId]);

	redirect_old();
}
