<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;
use app\Models\Activities\Test;

if (!Test::newWhere([Test::linkedIndexName(Section::class) => 15, 'step' => 4,],)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 15,
			'step' => 4,
			'title' => 'Probabile o improbabile',
			'description' => "Evidenzia nel testo le espressioni che indicano il grado di certezza (possibile/probabile/improbabile) delle informazioni riportate, cliccando prima sul bottone in basso per cominciare ad evidenziare e poi sulla parte del testo corrispondente",
			'shortDescription' => 'Cerca i marcatori di probabilità',
			'slug' => 'probabile',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}
