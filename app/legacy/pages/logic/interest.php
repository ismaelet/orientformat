<?php

use App\Models\Results\User\TestResult;
use Illuminate\Support\Facades\Auth;
use Legacy\Activity\Result\Handler\StudentTestResult;
use Legacy\Activity\Test;
use Legacy\UserSystem\Student;

$watch = $_GET['watch'] ?? false;

// interest data
$studentId = $_GET['student-id'] ?? Auth::id();
$student = new Student($studentId);
$highschool = $_GET['highschool'] ?? $student->isInHighschool;
$surveyTestId = $highschool ? 150 : 91;
$resultTestId = $highschool ? 151 : 92;
$interestId = $_GET['id'] ?? 1;

$interests = test_config($resultTestId, 'groups');
$interest = $interests[$interestId];

$result = ((new StudentTestResult($resultTestId, $studentId))->detailedResult)[$interestId - 1]['percentage'] ?? false;
$survey = (new Test($surveyTestId))->setStudentId($studentId);

// questions
$questions = [];

for ($i = 1; $i <= count(test_config($surveyTestId, 'questions')); $i++) {
    $questions[] = __('tests.'.$surveyTestId.'-question-'.$i);
}

$questionIds = $interest['questionIds'];

bump($questions);

// schools
$schoolList = (include_once '-expands-interest/'.($highschool ? 'universities' : 'schools').'.php')[$interestId] ?? false;

/*
* Form handling
*/
if (isset($_POST['edit'])) {
    $results = $survey->rawResults;

    foreach ($_POST['field'] as $resultId => $resultValue) {
        $results[$resultId] = $resultValue;
    }

    $results = implode(',', $results);

    TestResult::updateOrCreate(
        [
            'testId' => $surveyTestId,
            'studentId' => Auth::id(),
        ],
        [
            'result' => $results,
        ]
    );

    redirect_old();
}
