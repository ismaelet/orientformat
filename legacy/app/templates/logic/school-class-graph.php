<?php

/* TEMP */
foreach (schoolClass()->students as $student) {
	$student->calcPersonalData();
}
/* END TEMP */

$legacySectionId = $_GET['sectionId'];
$pageTitle = \Legacy\System\Classes\LegacyDB::find('name FROM sections WHERE id = ?', [$legacySectionId]);

$breadcrumbs = [
	schoolClass()->name => client_url('/class'),
	'Progresso della classe' => client_url('/class/class-progress/list'),
	$pageTitle => false,
];

// variables
$graphData['columns'] = [];
$divideBy = isset($_GET['divideBy']) && in_array($_GET['divideBy'], ['gender', 'decided', 'degree']) ? $_GET['divideBy'] : false;
$filterBy = isset($_GET['filterBy']) && in_array($_GET['filterBy'], ['gender', 'decided', 'degree']) ? $_GET['filterBy'] : false;
$filterRange = $_GET['range'] ?? false;

$divideByNames = [
	'degree' => 'in base al titolo di studio dei genitori<br><span class="txt-1rem">(in caso di diverso titolo di studio è preso come riferimento il maggiore tra i due)</span>',
	'decided' => 'in base alla sicurezza nella scelta della scuola superiore',
	'gender' => 'tra studenti e studentesse',
];

$filterByNames = [
	'degree' => [
		1 => 'che <strong>non hanno indicato</strong> il titolo di studio dei genitori',
		2 => 'che hanno almeno un genitore che ha conseguito la <strong>licenza elementare</strong> come titolo di studio più alto',
		3 => 'che hanno almeno un genitore che ha conseguito la <strong>licenza media</strong> come titolo di studio più alto',
		4 => 'che hanno almeno un genitore che ha conseguito il <strong>diploma o una qualifica professionale</strong> come titolo di studio più alto',
		5 => 'che hanno almeno un genitore <strong>laureato</strong>',
	],
	'decided' => [
		1 => 'che sono <strong>molto indecisi</strong> riguardo alla scelta della scuola superiore',
		2 => 'che sono <strong>abbastanza indecisi</strong> riguardo alla scelta della scuola superiore',
		3 => 'che sono <strong>abbastanza decisi</strong> riguardo alla scelta della scuola superiore',
		4 => 'che sono <strong>molto decisi</strong> riguardo alla scelta della scuola superiore',
		5 => 'che sono <strong>sicuri</strong> riguardo alla scelta della scuola superiore',
	],
	'gender' => [
		1 => 'che sono <strong>studenti (maschi)</strong>',
		2 => 'che sono <strong>studentesse</strong>',
		3 => 'che non hanno specificato il genere',
	],
];

if ($filterBy && !isset($filterByNames[$filterBy][$filterRange])) {
	$filterBy = false;
}

$graphData = generate_graph_data($legacySectionId, schoolClass(), $filterBy, $divideBy, $filterRange);
