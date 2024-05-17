<?php

$questions = [
	"Qual era l’attività prevalente di Peter?",
	"Peter sognava di",
	"Chi era l’uomo dal cappotto di caimano?",
	"Quale di queste è una delle prove sostenute da Peter per ricevere la chitarra magica?",
	"Chi era Lucifumandro?",
	"Quale di questi punti caratterizza l’aspetto esteriore di Lucifumandro?",
	"Qual è il titolo del pezzo che suonava Peter quando si avvicinò il vecchio?",
	"Peter venne ucciso",
	"Per strada Peter non riusciva a racimolare soldi",
	"Qual è l’elemento a sorpresa che crea l’interesse e l’originalità del racconto?",
];

$answers = [
	[
		'res' => ['Faceva l’operaio', 'Studiava in conservatorio', 'Era disoccupato', 'Faceva il giramondo'],
		'right' => 2
	],
	[
		'res' => ['diventare un divo del rock', 'diventare molto ricco', 'eliminare le ingiustizie sociali', 'visitare molti paesi'],
		'right' => 1
	],
	[
		'res' => ['Il malvagio Black Martin', 'Uno spettatore qualsiasi', 'Un manager discografico', 'Il mago degli effetti speciali'],
		'right' => 3
	],
	[
		'res' => ['Offre il seggiolino per sedersi', 'Presta il suo cappotto', 'Divide col vecchio il panino e la birra', 'Presta la sua sciarpa'],
		'right' => 4
	],
	[
		'res' => ['Il demonio', 'Il mago degli effetti speciali', 'Uno spirito cattivo', 'Un uomo malvagio e invidioso'],
		'right' => 2
	],
	[
		'res' => ['Porta i sandali', 'Ha i capelli a spazzola', ' Ha delle zeppe molto alte', 'Indossa un mantello nero'],
		'right' => 3
	],
	[
		'res' => ['Hey Joe', 'Satisfaction', 'Cross Road', 'Imagine'],
		'right' => 3
	],
	[
		'res' => ['con una pugnalata', 'con la corrente elettrica', 'con una tremenda botta in testa', 'col veleno'],
		'right' => 2
	],
	[
		'res' => ['perché li sperperava in alcool', 'perché suonava male', 'perché faceva freddo', 'perché era bassa stagione'],
		'right' => 3
	],
	[
		'res' => ['La morte di Peter', 'Il successo di Black Martin', 'Peter viene presto dimenticato dai suoi fan', 'Il difetto di fabbricazione'],
		'right' => 4
	],
];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
