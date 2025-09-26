<?php

use LogicManager\TestLogic;

$legacyTest = legacy_test();

$count = 20;

$groups = [];

for ($i = 1; $i <= 4; $i++) {
	$groups[] = __('tests.24-group-' . $i);
}

$results = \App\Legacy\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $legacyTest->id]);

if ($results) {
	$results = explode(',', $results);
}

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$results = implode(',', $_POST['field_other']);

		\App\Legacy\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), testId()]);
		\App\Legacy\LegacyDB::add('results_others (userID, testID, result)', [\Illuminate\Support\Facades\Auth::id(), testId(), $results]);

		return 100;
	});
