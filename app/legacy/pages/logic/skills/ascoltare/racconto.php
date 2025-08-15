<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LogicManager\TestLogic;

$legacyTest = test();

$results = [];

if (!isset($questions)) {
	$questions = [];

	for ($i = 1; $i <= 10; $i++) {
		$questions[] = __('tests.96-question-' . $i);
	}
}

$answers = $answers ?? [
	[
		'right' => 4
	],
	[
		'right' => 2
	],
	[
		'right' => 1
	],
	[
		'right' => 4
	],
	[
		'right' => 3
	],
	[
		'right' => 1
	],
	[
		'right' => 3
	],
	[
		'right' => 2
	],
	[
		'right' => 1
	],
	[
		'right' => 2
	],
];

foreach ($answers as $key => $answer) {
	$answers[$key]['res'] = [
		__('tests.96-answer-' . ($key + 1) . '-1'),
		__('tests.96-answer-' . ($key + 1) . '-2'),
		__('tests.96-answer-' . ($key + 1) . '-3'),
		__('tests.96-answer-' . ($key + 1) . '-4'),
	];
}

foreach ($questions as $questionKey => $question) {
	$questionData = [];
	$questionData['text'] = $questions[$questionKey];

	foreach ($answers[$questionKey]['res'] as $answerKey => $answer) {
		$answerData = [];
		$answerData['text'] = $answer;
		$answerData['checked'] = isset($legacyTest->rawResults[$questionKey]) && $legacyTest->rawResults[$questionKey] == $answerKey + 1;

		if ($legacyTest->completed && $answerData['checked']) {
			$answerData['class'] = $answerKey + 1 == $answers[$questionKey]['right'] ? 'right' : 'wrong';
		} else {
			$answerData['class'] = '';
		}

		$questionData['answers'][] = $answerData;
	}

	$content[] = $questionData;
}

$count = count($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$answers = \App\Legacy\LegacyView::getInstance()->get('answers');

		$rightN = 0;

		try {
			foreach ($_POST['field'] as $key => $value) {
				if ($value == $answers[$key]['right']) $rightN++;
			}
		} catch (\Exception $e) {
			Log::error('Post results not set in "Racconto"', ['userId' => Auth::id(), 'request' => request()->all()]);
		}

		return round($rightN / $count * 100);
	});
