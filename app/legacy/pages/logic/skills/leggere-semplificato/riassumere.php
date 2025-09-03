<?php

use LogicManager\TestLogic;

$legacyTest = test();

// results
$results = [];

for ($i = 1; $i <= 7; $i++) {
	$results[] = __('tests.39-missing-word-' . $i);
}

$options = [];

for ($i = 1; $i <= 7; $i++) {
	$options[] = ['id' => $i, 'text' => __('tests.39-missing-word-' . $i), 'correct' => true];
	$options[] = ['id' => $i, 'text' => __('tests.39-wrong-word-' . $i), 'correct' => false];
}

shuffle($options);

// text
$text = __('tests.39-summary');

$text = explode('{inp}', $text);

$count = count($text) - 1;

foreach ($text as $key => &$part) {
	if ($key) {
		if ($legacyTest->completed) {
			$inp = '<span class="font-bold underline ';
			$inp .= __en($legacyTest->rawResults[$key - 1]) == __en($results[$key - 1]) ? 'text-success-400' : 'text-error-400';
			$inp .= '">';
			$inp .= __('shared.' . __en($legacyTest->rawResults[$key - 1]));
			$inp .= '</span>';
		} else {
			$inp = '
			<input type="text" class="option js-field" name="field[]" value="';
			if ($legacyTest->result && isset($legacyTest->rawResults[$key - 1])) $inp .= $legacyTest->rawResults[$key - 1];
			$inp .= '" readonly>';
		}

		$part = $inp . '<span>' . $part . '</span>';
	}
}

$text = implode('', $text);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$results = \App\Legacy\LegacyView::getInstance()->get('results');
			$rightN = 0;

			foreach ($_POST['field'] as $key => $result) {
				if ($result == $results[$key]) {
					$rightN++;
				}
			}

			return round($rightN / $count * 100);
		}
	);
