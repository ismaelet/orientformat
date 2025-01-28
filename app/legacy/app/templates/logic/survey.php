<?php

$legacyTest = test();
$legacySection = $legacyTest->section;
$survey = $legacyTest->survey;

/**
 * Form handling
 */
if (!empty($_POST)) {
	$total = 0;
	$result = [];

	// get results
	$max = $survey->questionCount * ($survey->answerCount - 1);

	foreach ($_POST['field'] as $key => $value) {
		$result[] = $value;
		$total += $value;
	}

	$result = implode(',', $result);

	// get the score
	$score = round($total / $max * 100);

	// get the speed
	$speed = $_POST['speed'];

	// save result
	test()->saveResult($result, $score, 1, $speed);
	test()->advance();
}
