<?php

$legacyTest = test();
$sibling = $legacyTest->requiredTest;

$questions = [
	["Mi piace lavorare manualmente", 1],
	["Mi piace pianificare le mie attività", 1],
	["Mi piace usare arnesi e attrezzi", 1],
	["Mi piace conoscere piante e animali", 2],
	["Mi piace osservare i fenomeni naturali e pormi delle domande", 2],
	["Mi piace svolgere attività a contatto con la natura", 2],
	["Mi piace disegnare", 3],
	["Mi piace collegare sempre le idee astratte a situazioni concrete", 3],
	["Mi piace organizzare incontri o attività con amici/amiche", 1],
	["Mi piace proteggere la natura e stare attento/a a non inquinare", 2],
	["Mi piace affrontare e risolvere problemi", 4],
	["Mi piace risolvere indovinelli o altri giochi enigmistici", 4],
	["Mi piace soffermarmi a guardare immagini (quadri, foto, statue ecc.)", 3],
	["Mi piace fotografare", 3],
	["Mi piace ordinare e classificare", 4],
	["Mi piace fare calcoli e risolvere problemi matematici", 4],
	["Mi piace pormi delle domande sull’esistenza e il senso delle cose", 5],
	["Mi piace osservare il cielo e pormi domande sull’universo", 5],
	["Mi piace ascoltare musica", 6],
	["Mi piace ricordare a memoria le parole delle canzoni", 6],
	["Mi piace perdermi a fantasticare", 5],
	["Mi piace ascoltare storie o vedere dei film", 5],
	["Mi piace conversare o discutere", 7],
	["Mi piace ballare", 8],
	["Mi piace suonare uno strumento musicale", 6],
	["Mi piace studiare con una musica di sottofondo", 6],
	["Mi piace studiare insieme con un compagno o una compagna", 7],
	["Mi piace lavorare o fare attività in gruppo", 7],
	["Mi piace chiedermi come si sentono gli altri e cosa pensano", 7],
	["Mi piace praticare sport", 8],
	["Mi piace stare spesso in attività", 8],
	["Mi piace mettermi alla prova su abilità fisiche o osservare altri che lo fanno", 8],
];

$titles = [
	['Area tecnico-organizzativa', 'top'],
	['Area naturalistica', 'top'],
	['Area figurativo-spaziale', 'lef'],
	['Area logico-matematica', 'rig'],
	['Area esistenziale', 'lef'],
	['Area musicale', 'rig'],
	['Area verbale-interpersonale', 'bot'],
	['Area motoria', 'bot'],

	['Pratica', 'top'],
	['Introspettiva', 'lef'],
	['Analitica', 'rig'],
	['Interattiva', 'bot'],
];

bump($titles);

$boxes = false;

// calculate results
if ($sibling->completed) {

	$boxes = [];

	foreach ($questions as $key => $question) {

		$box = [];

		$box['question'] = $question[0];
		$box['group'] = $question[1];
		$box['result'] = $sibling->rawResults[$key];

		$boxes[$key + 1] = $box;
	}
}
