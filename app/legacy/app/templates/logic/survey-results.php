<?php

include_once __DIR__ . '/test.php';

$fixedQuestions = \App\Legacy\LegacyView::getInstance()->get('fixedQuestions');
$answers = null;
$total = 0;

$legacyTest = legacy_test();
$requiredTest = $legacyTest->requiredTest;
$survey = $requiredTest->survey;

$questions = $survey->questions;
$questionCount = $survey->questionCount;
$range  = $survey->answerCount;
$max = $questionCount * ($range - 1);

if ($requiredTest->completed) {
	$answers = [];

	foreach ($questions as $key => $question) {
		$answer = [];

		$answer['result'] = $requiredTest->rawResults[$key] ?? 0;
		$answer['question'] = $fixedQuestions[$key] ?? $question[0];
		$total += $answer['result'];

		$answers[] = $answer;
	}

	bump($answers);
}

$average = $total / $questionCount;
