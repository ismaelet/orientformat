<?php

use \Legacy\Activity\Result\AdditionalTestResult;
use LogicManager\TestLogic;

$count = 1;
$test = test();
$branchResults = $test->additionalPrimaryResult ?: null;
$fruitsResults = $test->additionalSecondaryResult ?: null;

if ($branchResults) {
	bump($branchResults);
}

if ($fruitsResults) {
	bump($fruitsResults);
}

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function () {
			$branches = implode(',', $_POST['branch']);
			$fruits = implode(',', $_POST['fruit']);

			\System\Classes\DBOld::delete(AdditionalTestResult::TABLE . ' WHERE ' . AdditionalTestResult::USER_INDEX . ' = ? AND ' . AdditionalTestResult::TEST_INDEX . ' = ?', [studentId(), testId()]);
			\System\Classes\DBOld::add(AdditionalTestResult::TABLE . ' (' . AdditionalTestResult::USER_INDEX . ', ' . AdditionalTestResult::TEST_INDEX . ', primaryResults, secondaryResults)', [studentId(), testId(), $branches, $fruits]);

			return 100;
		}
	);
