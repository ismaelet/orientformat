<?php

use LogicManager\TestLogic;

$legacyTest = test();

$count = 20;

$groups = ['La tua opinione', 'Docente o orientatore', 'Genitori o parenti', 'Amici'];
$results = \App\Legacy\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $legacyTest->id]);

if ($results) {
	$results = explode(',', $results);
}

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$results = implode(',', $_POST['field_other']);

		\App\Legacy\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), testId()]);
		\App\Legacy\LegacyDB::add('results_others (userID, testID, result)', [\Illuminate\Support\Facades\Auth::id(), testId(), $results]);

		return 100;
	});
