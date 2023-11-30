<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;
use app\Models\Activities\Test;

if (!Section::exists(57)) {
	$sectionId = Section::add([
		'areaId' => 2,
		'name' => 'Scrivere',
		'slug' => 'scrivere-intermedio',
		'description' => 'Governare una tecnica potente',
		'grades' => '6,9',
		'years' => '6L,6P',
		'mainSectionId' => 14,
		'time' => 0
	]);
}

if (!Test::newFromStep(57, 1)) {
	$surveryId = Test::duplicateEntry(181, [
		Test::linkedIndexName(Section::class) => 57,
	]);
}

if (!Test::newFromStep(57, 2)) {
	$recapId = Test::duplicateEntry(180, [
		Test::linkedIndexName(Section::class) => 57,
		'requiredTestId' => $surveryId
	]);

	(new Test($surveryId))->post([
		'followUpTestId' => $recapId
	]);
}

if (!Test::newFromStep(57, 3)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 57,
			'step' => 3,
			'title' => 'Punteggiatura - 1',
			'description' => "Inserisci nel testo i segni di punteggiatura corretti, selezionandoli tra le opzioni possibili.",
			'shortDescription' => 'Inserisci i segni di punteggiatura',
			'slug' => 'punteggiatura',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}

if (!Test::newFromStep(57, 4)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 57,
			'step' => 4,
			'title' => 'Punteggiatura - 2',
			'description' => "Inserisci nel testo i segni di punteggiatura corretti, selezionandoli tra le opzioni possibili.",
			'shortDescription' => 'Inserisci i segni di punteggiatura',
			'slug' => 'punteggiatura',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}
