<?php

use LogicManager\TestLogic;

$test = test();

$count = 20;

$groups = ['La tua opinione', 'Docente o orientatore', 'Genitori o parenti', 'Amici'];
$results = \Legacy\System\Classes\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $test->id]);

if ($results) {
	$results = explode(',', $results);
}

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$results = implode(',', $_POST['field_other']);

		\Legacy\System\Classes\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [studentId(), testId()]);
		\Legacy\System\Classes\LegacyDB::add('results_others (userID, testID, result)', [studentId(), testId(), $results]);

		return 100;
	});
