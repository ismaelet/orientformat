<?php

$legacyTest = test();
$sibling = $legacyTest->requiredTest;

$max = 0;
$results = [];
$fields = ['Tenacia', 'Pregiudizio', 'Abilità', 'Destino', 'Strategia', 'Dipendenza', 'Emozione', 'Caso'];

$descriptions = [
	'<strong>Tenacia:</strong> quando si è determinati e costanti',
	'<strong>Pregiudizio:</strong> quando dipende dalle convinzioni che gli altri hanno su di te',
	'<strong>Abilità:</strong> quando dipende soprattutto dalla propria capacità',
	'<strong>Destino:</strong> quando tutto sembra già deciso',
	'<strong>Strategia:</strong> quando si sa ciò che si vuole e come fare per ottenerlo',
	'<strong>Dipendenza:</strong> quando sono gli altri a determinare i risultati',
	'<strong>Emozione:</strong> quando è lo stato d\'animo a essere determinante',
	'<strong>Caso:</strong> quando tutto o quasi dipende dalla fortuna o dalla sfortuna',
];

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
