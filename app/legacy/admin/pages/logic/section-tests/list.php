<?php

// select table
$index = 'id';
$tbl = 'tests';
$add = false;
$query['select'] = '*, tests.id as testId, sections.name as sectionTitle, areas.name as areaTitle, (SELECT COUNT(*) FROM results_permanent WHERE testID=tests.id) as completedCount, (SELECT AVG(speed) as averageTime FROM results_permanent WHERE testID=tests.id) AS rawSpeed';
$query['index'] = 'areaID ASC, sectionID ASC, step';
$query['order'] = 'ASC';
$query['where'] = 'tests.active = 1 AND sections.active = 1 AND template<>"recap"';
$query['from'] = '
	tests
		INNER JOIN sections
			ON tests.sectionID = sections.id
		INNER JOIN areas
			ON tests.areaID = areas.id
';

// handle search
$query['filter'] = "
	classes.id = ? OR CONCAT(grade, letter) = ? OR schools.name = ?
";

// select fields
$fields = [
	['title' => 'ID', 'name' => 'testId', 'size' => 1],
	['title' => 'Titolo', 'name' => 'title', 'size' => 2],
	['title' => 'Sezione', 'name' => 'sectionTitle', 'size' => 2],
	['title' => 'Area', 'name' => 'areaTitle', 'size' => 2],
	['title' => 'Completato dal', 'name' => 'completed', 'size' => 1, 'not-sortable' => true],
	['title' => 'Tempo medio', 'name' => 'speed', 'size' => 1, 'not-sortable' => true],
];

function _expand_results(&$entry, $field, $key, $row) {
	$studentCount = DB::count('students WHERE status=1');

	if ($field['name'] == 'completed') {
		$entry['value'] = round($row['completedCount'] / $studentCount * 100) . ' %';
	} else if ($field['name'] == 'speed') {
		$averageTime = round($row['rawSpeed']);

		if ($averageTime > 59) {
			$averageTime = round($averageTime / 60);
			$entry['value'] = $averageTime != 1 ? $averageTime . ' minuti' : '1 minuto';
		} else {
			$entry['value'] = $averageTime != 1 ? $averageTime . ' secondi' : '1 secondo';
		}
	}
}
