<?php

$legacyTest = test();

$options = [
	'CARTA',
	'TELEFONO',
	'STUFA',
	'OCCHIO',
	'SALTO',
	'COLLA',
	'SCHERMO',
	'SASSO',
	'QUADERNO',
	'LAMPADINA',
	'CANE',
	'AUTO',
	'BICICLETTA',
	'MANO',
	'SOLE',
	'STRADA',
	'NUVOLA',
	'VENTO',
	'RAMO',
	'MOSCA',
	'CAPPELLO',
	'ROCCIA',
	'CAMICIA',
	'CAPPOTTO',
	'FORCHETTA',
	'LUNA',
	'GOMMA',
	'PENNA',
	'PIATTO',
	'FERROVIA',
	'ERBA',
	'CASA',
	'NEVE',
	'BOTTE',
	'TRENO',
	'ALBERO',
	'COLLA',
	'TORRE',
];

$viewMatch = [4, 10, 12, 13, 15, 19, 21, 24, 26, 29, 32, 34];
$hearMatch = [1, 5, 8, 11, 14, 16, 22, 27, 28, 31, 35, 36];

if ($legacyTest->completed) {
	$viewCount = 0;
	$hearCount = 0;
	$errorCount = 0;
	$maxView = count($viewMatch);
	$maxHear = count($hearMatch);
	$maxErrors = count($options) - $maxView - $maxHear;
	$results = $legacyTest->rawResults;

	foreach ($results as $result) {
		if (in_array($result, $viewMatch)) {
			$viewCount++;
		} else if (in_array($result, $hearMatch)) {
			$hearCount++;
		} else {
			$errorCount++;
		}
	}

	$viewScore = round($viewCount / $maxView * 100);
	$hearScore = round($hearCount / $maxHear * 100);
	$errorScore = round($errorCount / $maxErrors * 100);
}
