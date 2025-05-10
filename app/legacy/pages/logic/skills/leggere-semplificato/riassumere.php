<?php

use LogicManager\TestLogic;

$legacyTest = test();

// results
$results = [];

for ($i = 1; $i <= 7; $i++) {
	$results[] = __('tests.39-missing-word-' . $i);
}

// text
$text = __('tests.39-summary');

$text = explode('{inp}', $text);

$count = count($text) - 1;

foreach ($text as $key => &$part) {
	if ($key) {
		if ($legacyTest->completed) {
			$inp = '<span class="text-inp fa-center ';
			$inp .= $legacyTest->rawResults[$key - 1] == $results[$key - 1] ? 'right' : 'wrong';
			$inp .= '">';
			$inp .=  $legacyTest->rawResults[$key - 1];
			$inp .= '</span>';
		} else {
			$inp = '<input type="text" class="inp text-inp filler-inp" name="field[]" value="';
			if ($legacyTest->result && isset($legacyTest->rawResults[$key - 1])) $inp .= $legacyTest->rawResults[$key - 1];
			$inp .= '" ' . (test()->completed || isSupervisor() ? 'readonly' : null) . '>';
		}

		$part = $inp . $part;
	}
}

$text = implode('', $text);

\LogicManager\TestLogic::setParameterCount($count)
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
