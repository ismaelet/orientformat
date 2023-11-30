<?php

use Activity\Test;
use LogicManager\TestLogic;

include_once('-expands-test/components.php');

/**
 * Form handling
 */
if (isset($_POST['submit']) || isset($_POST['review']) || isset($_POST['skip'])) {
	if (test()->template != 'test-next') {
		// get the score
		$score = TestLogic::$testSubmitFunction ? TestLogic::runTestSubmitFunction() : 100;

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
		test()->saveResult($result, $score, $completed, $speed);
		test()->advance(isset($_POST['review']));
	}
}

if (isset($_POST['redo'])) {
	(new Test($_POST['redo']))->redo();
}
