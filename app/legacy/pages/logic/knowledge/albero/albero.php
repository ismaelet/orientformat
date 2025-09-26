<?php

use \Legacy\Activity\Result\AdditionalTestResult;
use LogicManager\TestLogic;

$count = 1;
$legacyTest = legacy_test();
$branchResults = $legacyTest->additionalPrimaryResult ?: null;
$fruitsResults = $legacyTest->additionalSecondaryResult ?: null;

if ($branchResults) {
	bump($branchResults);
}

if ($fruitsResults) {
	bump($fruitsResults);
}

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function () {
			$branches = implode(',', $_POST['branch']);
			$fruits = implode(',', $_POST['fruit']);

			\App\Legacy\LegacyDB::delete(AdditionalTestResult::TABLE . ' WHERE ' . AdditionalTestResult::USER_INDEX . ' = ? AND ' . AdditionalTestResult::TEST_INDEX . ' = ?', [\Illuminate\Support\Facades\Auth::id(), testId()]);
			\App\Legacy\LegacyDB::add(AdditionalTestResult::TABLE . ' (' . AdditionalTestResult::USER_INDEX . ', ' . AdditionalTestResult::TEST_INDEX . ', primaryResults, secondaryResults)', [\Illuminate\Support\Facades\Auth::id(), testId(), $branches, $fruits]);

			return 100;
		}
	);
