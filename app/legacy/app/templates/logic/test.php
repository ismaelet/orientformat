<?php

use \Legacy\Activity\Test as LegacyTest;
use Legacy\LogicManager\TestLogic;

$legacyTest = test();
$legacySection = $legacyTest->section;
$supervisorView = request()->student_id;

include_once('-expands-test/components.php');

/**
 * Form handling
 */
if (isset($_POST['submit']) || isset($_POST['review']) || isset($_POST['skip'])) {

	if (test()->template != 'test-next') {
		// get the score
		$score = TestLogic::$legacyTestSubmitFunction ? TestLogic::runTestSubmitFunction() : 100;

		// save the results
		$result = [];

		if (isset($_POST['field'])) {
			foreach ($_POST['field'] as $value) {
				$result[] = $value;
			}
		}

		$result = implode(',', $result);

		// get the speed
		$speed = $_POST['speed'] ?? 0;

		// get if the test is completed
		$completed = !isset($_POST['skip']);

		// save result
		$legacyTest->saveResult($result, $score, $completed, $speed);
		$legacyTest->advance(isset($_POST['review']));
	}
}

if (isset($_POST['redo'])) {
	(new LegacyTest($_POST['redo']))->redo();
}
