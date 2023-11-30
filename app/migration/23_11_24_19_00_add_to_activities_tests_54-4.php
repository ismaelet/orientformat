<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;
use app\Models\Activities\Test;

if (!Test::newFromStep(54, 4)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 54,
			'step' => 4,
			'title' => 'Il punto di vista',
			'description' => "Nei brani riportati, sono sottolineate alcune espressioni. Di chi è “il punto di vista” (ovvero la percezione, anche uditiva, la “focalizzazione”)?

			Clicca prima sul tipo di punto di vista e poi (senza trascinare) sulla parte di testo relativa.",
			'shortDescription' => 'Analizza il testo',
			'slug' => 'punto-di-vista',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}

$test = Test::newFromStep(54, 1);
$test->post(
	[
		'description' => "Leggi e poi scegli l'espressione che dovrai rintracciare nel testo: clicca prima sull'espressione e poi (senza trascinare) sulla parte di testo relativa. Ad una espressione possono corrispondere più parti del testo, quando le avrai trovate tutte il selettore diventerà grigio e inattivo.
			
		Se non riesci a trovare tutte le parti, puoi cliccare su \"Salta questa attività\", e completarla in un secondo momento.",
	]
);

$test = Test::newFromStep(54, 2);
$test->post(
	[
		'description' => "Leggi e poi scegli l'espressione che dovrai rintracciare nel testo: clicca prima sull'espressione e poi (senza trascinare) sulla parte di testo relativa. Ad una espressione possono corrispondere più parti del testo, quando le avrai trovate tutte il selettore diventerà grigio e inattivo.
			
		Se non riesci a trovare tutte le parti, puoi cliccare su \"Salta questa attività\", e completarla in un secondo momento.",
	]
);

$test = Test::newFromStep(54, 4);
$test->post(
	[
		'slug' => "punto-di-vista",
	]
);
