<?php

use \Legacy\Activity\Test as LegacyTest;
use Legacy\LogicManager\TestLogic;

$legacyTest = legacy_test();
$legacySection = $legacyTest->section;
$supervisorView = request()->student_id;

/**
 * Form handling
 */
if (isset($_POST['submit']) || isset($_POST['review']) || isset($_POST['skip'])) {
    if (legacy_test()->template != 'test-next') {
        if (legacy_test()->completed) {
            $legacyTest->advance();
        } else {
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
}

if (isset($_POST['redo'])) {
    (new LegacyTest($_POST['redo']))->redo();
}
