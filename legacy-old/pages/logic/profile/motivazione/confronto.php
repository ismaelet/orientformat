<?php

use LogicManager\TestLogic;

$test = test();

$count = 20;

$groups = ['La tua opinione', 'Docente o orientatore', 'Genitori o parenti', 'Amici'];
$results = DB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $test->id]);

if ($results) {
	$results = explode(',', $results);
}

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		$results = implode(',', $_POST['field_other']);

		DB::delete('results_others WHERE userID = ? AND testID = ?', [studentId(), testId()]);
		DB::add('results_others (userID, testID, result)', [studentId(), testId(), $results]);

		return 100;
	});
