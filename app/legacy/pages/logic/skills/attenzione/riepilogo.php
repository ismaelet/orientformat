<?php

$legacyTest = test();

// setup variables
$answers = false;
$focus['score'] = 0;
$hyper['score'] = 0;

$sibling = $legacyTest->requiredTest;

$questions = [
	__("surveys.136"),
	__("surveys.137"),
	__("surveys.138"),
	__("surveys.139"),
	__("surveys.140"),
	__("surveys.141"),
	__("surveys.142"),
	__("surveys.143"),
	__("surveys.144"),
	__("surveys.145"),
	__("surveys.146"),
	__("surveys.147"),
	__("surveys.148"),
	__("surveys.149"),
	__("surveys.150"),
	__("surveys.151"),
	__("surveys.152"),
	__("surveys.153"),
];

$questN = count($questions);
$max = $questN * 2;

if ($sibling->completed) {

	$answers = [];

	foreach ($questions as $key => $question) {

		$answer = [];

		$answer['result'] = isset($sibling->rawResults[$key]) ? $sibling->rawResults[$key] + 1 : 0;
		$answer['critical'] = $answer['result'] > 2;
		$answer['question'] = $question;

		$answers[] = $answer;

		if ($key % 2) $hyper['score'] += $answer['result'];
		else $focus['score'] += $answer['result'];
	}

	bump($answers);

	$focus['width'] = $focus['score'] / $max * 100;
	$hyper['width'] = $hyper['score'] / $max * 100;

	$focus['critical'] = $focus['score'] > $max / 2;
	$hyper['critical'] = $hyper['score'] > $max / 2;
}
