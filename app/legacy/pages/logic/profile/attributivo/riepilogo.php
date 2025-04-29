<?php

$legacyTest = test();
$sibling = $legacyTest->requiredTest;

$max = 0;
$results = [];
$fields = [];
$descriptions = [];

for ($i = 1; $i <= 8; $i++) {
	$fields[] = __('tests.48-field-' . $i);
	$descriptions[] = __('tests.48-description-' . $i);
}

if ($sibling->completed) {
	foreach ($fields as $key => $field) {
		$results[$key]['label'] = $field;
		$results[$key]['positive-result'] = 0;
		$results[$key]['negative-result'] = 0;
		$results[$key]['positive-height'] = 0;
		$results[$key]['negative-height'] = 0;
	}

	foreach ($sibling->rawResults as $key => $value) {
		$fieldKey = $value - 1;
		$type = $key % 2 ? 'positive-result' : 'negative-result';
		$results[$fieldKey][$type]++;

		if ($results[$fieldKey][$type] > $max) {
			$max = $results[$fieldKey][$type];
		}
	}

	foreach ($results as $key => $result) {
		$height = round($result['positive-result'] / $max * 86) + 14;
		$results[$key]['positive-height'] = $height;

		$height = round($result['negative-result'] / $max * 86) + 14;
		$results[$key]['negative-height'] = $height;
	}
}
