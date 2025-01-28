<?php

$questions = [
	"L’armadio di nonna Betta conteneva",
	"La pupazzetta aveva in testa",
	"Bettina amava molto la pupazzetta perché",
	"Un brutto giorno, quando aveva cinque anni, nonna Betta",
	"Perché Bettina decide di chiamarla Sovrana?",
	"Bettina abbandona la pupazzetta",
	"Una sera d’agosto la pupazzetta si butta di sotto e fa un gran botto",
	"La pupazzetta ha perso un braccio ed una gamba",
	"Cosa significa la parola “malandrino”?",
	"La pupazzetta è chiamata “cenciosa”",
];

$answers = [
	[
		'res' => ['Balocchi di fanciullezza', 'Vecchie fotografie', 'Una bambola di pezza e cartapesta'],
		'right' => 3
	],
	[
		'res' => ['Tanti riccioli', 'Pochi capelli', 'Nessun capello'],
		'right' => 2
	],
	[
		'res' => ['Era la sua prima bambola', 'Era la sua prediletta', 'Aveva sul vestito una spilletta'],
		'right' => 1
	],
	[
		'res' => ['Trova in un armadio una bambola di pezza', 'Riceve in regalo una bambola di porcellana', 'Riceve in regalo una bambola di lana'],
		'right' => 2
	],
	[
		'res' => ['Perché ha una corona in testa', 'Perché le piaceva comandare a tutte le bambole', 'Era bella ed elegante come una regina'],
		'right' => 3
	],
	[
		'res' => ['Perché Sovrana prende il suo posto', 'Perché si è dimostrata cattiva nei confronti di Sovrana', 'Perché le mancano un braccio e una gamba'],
		'right' => 1
	],
	[
		'res' => ['Perché Bettina abbraccia Sovrana ed è gelosa', 'Perché il malandrino l’ha fatta cadere', 'Per avvisare Bettina di un pericolo imminente'],
		'right' => 3
	],
	[
		'res' => ['Per salvare Bettina dal ladro di bambini', 'In una rissa con Sovrana', 'Perché nel tempo la stoffa si è rovinata'],
		'right' => 1
	],
	[
		'res' => ['Furfante', 'Venditore di mandarini', 'Sempliciotto'],
		'right' => 1
	],
	[
		'res' => ['Perché fa i capricci', 'Perché ha tanti nodi tra i capelli', 'Perché ha un vestito di pezza tutto rovinato'],
		'right' => 3
	],
];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

\App\Legacy\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
\App\Legacy\ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
