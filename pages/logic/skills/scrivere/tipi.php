<?php

use LogicManager\TestLogic;

$types = [
	'Scrivere un\'esposizione',
	'Scrivere un post su un social network',
	'Scrivere una poesia da leggere a qualcuno',
	'Scrivere un racconto',
	'Scrivere un riassunto per un compito o per qualcuno',
	'Scrivere delle istruzioni',
	'Scrivere un\'e-mail',
	'Scrivere in un diario',
	'Scrivere un riassunto per te',
	'Scrivere una poesia che non verrà letta da altri',
	'Fare uno schema per te',
	'Fare un brainstorming',
	'Fare uno schema da mostrare ad altri',
	'Fare una mappa',
	'Scrivere un promemoria',
	'Prendere appunti',
];

$count = count($types);

TestLogic::setParameterCount($count);
