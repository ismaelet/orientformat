<?php

$questions = [
	"Daniel Baker era",
	"Il venditore ambulante chiede ospitalità perché",
	"Il reverendo Cummings passa vicino alla casa",
	"Il reverendo Cummings, quando vede una figura sul ponte,",
	"Il misterioso uomo del ponte",
	"Il prete, dopo la scomparsa dell’uomo,",
	"Trovano il cadavere di un impiccato",
	"Sotto il terreno soffice del pendio sotto il ponte trovano le ossa",
	"Daniel Baker muore perché",
	"La duplice inchiesta del coroner stabilì che",
];

$answers = [
	[
		'res' => ['un venditore ambulante', 'un padre battista', 'il proprietario della casa', 'un vicino del proprietario'],
		'right' => 3
	],
	[
		'res' => ['era consuetudine fare così in quei tempi', 'conosceva il proprietario della casa', 'non aveva i soldi per pagare l’albergo', 'era l’unica casa che si trovava in quel posto'],
		'right' => 1
	],
	[
		'res' => ['in una notte buia e nebbiosa', 'dopo qualche giorno dalla scomparsa del venditore ambulante', 'poco prima che il venditore ambulante scomparisse', 'dopo qualche anno dalla scomparsa del venditore ambulante'],
		'right' => 4
	],
	[
		'res' => ['capisce subito che si trattava di un venditore ambulante', 'si chiede quale lavoro potesse mai fare un uomo in giro a quell’ora', 'capisce che era un fantasma, per il suo aspetto assente, come di un sonnambulo', 'pensa che sia il proprietario della casa che si trovava lì vicino'],
		'right' => 1
	],
	[
		'res' => ['chiede un passaggio al reverendo', 'indica qualcosa sotto il ponte', 'scompare nel momento in cui il prete gli rivolge la parola', 'dice al reverendo Cummings che aveva smarrito la strada'],
		'right' => 2
	],
	[
		'res' => ['decide di tornare indietro per vedere se l’uomo ricompariva', 'ritorna subito sul ponte accompagnato da due vicini di casa', ' ritorna sul luogo accompagnato dai suoi familiari', 'ritorna sul ponte la mattina dopo in compagnia di due vicini'],
		'right' => 4
	],
	[
		'res' => ['nei pressi del ponte', 'appeso al ponte', 'davanti alla casa del vecchio', 'sul greto del torrente'],
		'right' => 2
	],
	[
		'res' => ['di una donna scomparsa alcuni anni prima', 'del vecchio proprietario', 'del venditore ambulante', 'di un cavallo'],
		'right' => 3
	],
	[
		'res' => ['viene ucciso da qualcuno che non si sa chi sia', 'è terrorizzato dalla comparsa del fantasma', 'è torturato dai sensi di colpa', 'era affetto da una malattia incurabile'],
		'right' => 2
	],
	[
		'res' => ['il venditore ambulante era stato ucciso da ignoti', 'il venditore ambulante era stato ucciso dal vecchio proprietario di casa', 'il vecchio era stato ucciso dal venditore ambulante', 'entrambi era morti suicidandosi'],
		'right' => 1
	],
];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
