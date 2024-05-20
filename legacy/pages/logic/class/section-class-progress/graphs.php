<?php

use \Legacy\Activity\Section;

$areas = [];

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
		$legacySectionRes = \App\Legacy\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, grades) ORDER BY grades ASC', [$area['id'], $gradeId]);

		if (!empty($legacySectionRes->res)) {
			$doableSections = array_merge($doableSections, $legacySectionRes->res);
		}
	}

	$doableSections = array_keys(array_column($doableSections, null, 'id'));
	$doableSections = array_unique($doableSections);
	$doableSections = array_reverse($doableSections);

	foreach ($doableSections as $doableSectionId) {
		if (in_array($doableSectionId, [
			// Profilo - Stili cognitivi
			1, 28, 36, 37,
			// Profilo - Resilienza
			3,
			// Profilo - Autostima
			4, 29, 41,
			// Profilo - Risolvere i problemi
			5, 30,
			// Profilo - Stile atributivo
			6,
			// Profilo - Motivazione
			7,
			// Profilo - Temperamento
			8,
			// Profilo - La ruota delle emozioni
			27,
			// Competenze - Stare Attenti
			9, 31,
			// Competenze - Ricordare
			10, 32,
			// Competenze - Ascoltare
			11,	33,
			// Competenze - Parlare
			12,
			// Competenze - Scrivere
			14, 34,
			// Competenze - Leggere
			39,
			// Competenze - Imparare
			40,
			// Saperi - Creatività
			17,
			// Scegliere - Interessi
			24, 45,
		])) {
			$area['sections'][] = new Section($doableSectionId);
		}
	}

	if ($area['sections']) {
		$areas[] = $area;
	}
}
