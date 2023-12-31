<?php

use Activity\Section;

$areas = [];

// redirect('/maintenance');
$availableGrades = [];

if (schoolClass()->isMiddleSchool) {
	for ($i = 1; $i <= schoolClass()->currentGrade; $i++) {
		$availableGrades[] = $i;
	}
} else if (!schoolClass()->isProfessional) {
	for ($i = 4; $i <= schoolClass()->currentGrade; $i++) {
		$availableGrades[] = $i;
	}
} else {
	for ($i = 4; $i <= schoolClass()->currentGrade; $i++) {
		if ($i < 6 || $i > 8) {
			$availableGrades[] = $i;
		}
	}
}

// content
foreach (schoolClass()->doableAreas as $doableArea) {
	$area['name'] = $doableArea->name;
	$area['id'] = $doableArea->id;
	$area['sections'] = [];

	$doableSections = [];

	foreach ($availableGrades as $gradeId) {
		$sectionRes = DB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, grades) ORDER BY grades ASC', [$area['id'], $gradeId]);

		if (!empty($sectionRes->res)) {
			$doableSections = array_merge($doableSections, $sectionRes->res);
		}
	}


	$doableSections = array_keys(array_column($doableSections, null, 'id'));
	$doableSections = array_unique($doableSections);

	foreach ($doableSections as $doableSectionId) {
		if (in_array($doableSectionId, [
			// Stili cognitivi
			1, 28, 36, 37,
			// Autostima
			4, 29, 41,
			// Stile atributivo
			6,
			// Motivazione
			7,
			// Interessi
			24, 45,
			// La ruota delle emozioni
			27,
			// Ascoltare
			11,
		])) {
			$area['sections'][] = new Section($doableSectionId);
		}
	}

	if ($area['sections']) {
		$areas[] = $area;
	}
}
