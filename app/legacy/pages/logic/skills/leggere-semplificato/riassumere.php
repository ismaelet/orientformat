<?php

use LogicManager\TestLogic;

$legacyTest = legacy_test();

// results
$correctAnswers = [];

for ($i = 1; $i <= 7; $i++) {
	$correctAnswers[] = $i;
}

$options = [];

for ($i = 1; $i <= 14; $i++) {
	$options[] = ['id' => $i, 'text' => __('tests.39-missing-word-' . $i), 'correct' => true];
}

shuffle($options);

// text
$text = __('tests.39-summary');

$text = explode('{inp}', $text);

$count = count($text) - 1;

foreach ($text as $key => &$part) {
	if ($key) {
		$inputId = $key - 1;

		if ($legacyTest->completed) {
			$result = $legacyTest->rawResults[$inputId];
			$inp = '<span class="font-bold underline ';
			$inp .= $result == $correctAnswers[$inputId] ? 'text-success-400' : 'text-error-400';
			$inp .= '">';
			$inp .= __('tests.' . $legacyTest->id . '-missing-word-' . $result);
			$inp .= '</span>';
		} else {
			$value = legacy_test()->rawResults[$key - 1] ?? '';
			$inp = '
			<label class="droppable"><span class="option"></span><input type="hidden" class="js-field" name="field[]" value="' . $value . '" readonly></label>';
		}

		$part = $inp . '<span>' . $part . '</span>';
	}
}

$text = implode('', $text);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$correctAnswers = \App\Legacy\LegacyView::getInstance()->get('correctAnswers');
			$rightN = 0;

			foreach ($_POST['field'] as $key => $result) {
				if ($result == $correctAnswers[$key]) {
					$rightN++;
				}
			}

			return round($rightN / $count * 100);
		}
	);
