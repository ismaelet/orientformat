<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;
use app\Models\Activities\Test;

if (!Test::newFromStep(56, 2)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 56,
			'step' => 2,
			'title' => 'Racconto: Brutali e affascinanti',
			'description' => "Scegli la domanda ed evidenzia nel testo, cliccando prima sulla domanda e poi sulla parte di testo corrispondente.",
			'shortDescription' => 'Analizza il testo',
			'slug' => 'racconto-brutali',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}

if (!Test::newFromStep(56, 3)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 56,
			'step' => 3,
			'title' => 'Gradi di certezza del racconto',
			'description' => "Evidenzia nel testo le espressioni che indicano il grado di certezza (possibile/probabile/improbabile) delle informazioni riportate, cliccando prima sul bottone in fondo al testo e poi sulla parte di testo che indica un grado di sicurezza.",
			'shortDescription' => 'Cerca i marcatori di probabilità',
			'slug' => 'gradi-di-certezza',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}
