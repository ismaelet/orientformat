<?php

use LogicManager\TestLogic;

$legacyTest = test();

$colors = ['c4', 'c1', 'c5', 'c2'];

$questions = [];

for ($i = 1; $i <= 12; $i++) {
	$question = [
		'text' => __('tests.71-text-' . $i),
		'answers' => [],
		'emotions' => [],
	];

	for ($k = 1; $k <= 4; $k++) {
		$question['answers'][] = __('tests.71-answer-' . $i . '-' . $k);
	}

	for ($k = 1; $k <= 3; $k++) {
		$question['emotions'][] = __('tests.71-emotion-' . $i . '-' . $k);
	}

	$questions[] = $question;
}

$answers = [2, 4, 3, 2, 1, 2, 1, 2, 1, 2, 2, 4];
$answers_emotions = [
	[2],
	[3],
	[1],
	[2],
	[2, 4],
	[1, 4],
	[1, 3],
	[1],
	[1],
	[1, 4],
	[2, 3],
	[2, 3],
];

$results_emotions = explode(',', \App\Legacy\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id]));

$count = count($questions) * 2;

bump($questions);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$rightN = 0;
		$answers = \App\Legacy\LegacyView::getInstance()->get('answers');
		$answers_emotions = \App\Legacy\LegacyView::getInstance()->get('answers_emotions');

		$results = implode(',', $_POST['field_other']);

		\App\Legacy\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), testId()]);
		\App\Legacy\LegacyDB::add('results_others (userID, testID, result) VALUES (?, ?, ?)', [\Illuminate\Support\Facades\Auth::id(), testId(), $results]);

		foreach ($_POST['field'] as $key => $field) {
			if ($field == $answers[$key]) {
				$rightN++;
			}
		}

		foreach ($_POST['field_other'] as $key => $field) {
			$valid = true;
			$values = explode('+', $field);
			$emotions = $answers_emotions[$key];

			foreach ($values as $val) {
				if (!in_array($val, $emotions)) {
					$valid = false;
				}
			}

			foreach ($emotions as $emotion) {
				if (!in_array($emotion, $values)) {
					$valid = false;
				}
			}

			if ($valid) $rightN++;
		}

		return round($rightN / $count * 100);
	});
