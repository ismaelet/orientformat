<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;
use app\Models\Activities\Test;

DB::delete(Test::table() . ' WHERE ' . Test::linkedIndexName(Section::class) . ' = 54');

if (!Test::newFromStep(54, 1)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 54,
			'step' => 1,
			'title' => 'Analizza il test: Eveline - 1',
			'description' => "Leggi e poi scegli il tipo di ragionamento che dovrai rintracciare nel testo: clicca prima sul tipo di ragionamento e poi (senza trascinare) sulla parte di testo relativa. A un tipo di ragionamento possono corrispondere più parti del testo, quando le avrai trovate tutte il selettore diventerà grigio e inattivo.
			
			Se non riesci a trovare tutte le parti, puoi cliccare su \"Salta questa attività\", e completarla in un secondo momento.",
			'shortDescription' => 'Analizza il testo',
			'slug' => 'racconto-eveline-1',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}

if (!Test::newFromStep(54, 2)) {
	Test::add(
		[
			Test::linkedIndexName(Area::class) => 2,
			Test::linkedIndexName(Section::class) => 54,
			'step' => 2,
			'title' => 'Analizza il test: Eveline - 2',
			'description' => "Nei brani riportati, sono sottolineate alcune espressioni. Di chi è “il punto di vista” (la percezione, anche uditiva, la “focalizzazione”)? Clicca prima su un punto di vista e poi (senza trascinare) sulla parte di testo relativa. A un punto di vista possono corrispondere più parti del testo, quando le avrai trovate tutte il selettore diventerà grigio e inattivo.

			Se non riesci a trovare tutte le parti, puoi cliccare su \"Salta questa attività\", e completarla in un secondo momento.",
			'shortDescription' => 'Analizza il testo',
			'slug' => 'racconto-eveline-2',
			'template' => 'test-next',
			'reviewResult' => 1,
		]
	);
}
