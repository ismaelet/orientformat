<?php

use LogicManager\TestLogic;

$colors = ['c4', 'c1', 'c5', 'c2'];

$questions = [
	"Se una verifica è andata <span class='font-bold good'>bene</span> di solito è perché",
	"Se una verifica è andata <span class='font-bold bad'>male</span> di solito è perché",
	"Quando il mio rapporto con i compagni è <span class='font-bold good'>positivo</span> in genere è perché",
	"Quando il mio rapporto con i compagni è <span class='font-bold bad'>negativo</span> in genere è perché",
	"Quando il mio rapporto con l’insegnante funziona <span class='font-bold good'>bene</span> è perché",
	"Quando il mio rapporto con l’insegnante funziona <span class='font-bold bad'>male</span> è perché",
	"Quando il mio rapporto con una persona funziona <span class='font-bold good'>bene</span> è perché",
	"Quando il mio rapporto con una persona funziona <span class='font-bold bad'>male</span> è perché",
];

$answers = [
	[
		"Sono stato attento durante le lezioni e ho  imparato bene l’argomento",
		"Sono simpatico all'insegnante",
		"Sono portato per quella materia",
		"Era molto facile e avevo tutto il tempo necessario",
		"Mi sono impegnato molto",
		"Sono stato aiutato (dall’insegnante o da un compagno)",
		"Ero di buon umore",
		"Ho avuto fortuna",
	],
	[
		"Mi sono distratto durante le lezioni e non ho  imparato bene l’argomento",
		"L’insegnante mi trascura",
		"Non sono portato per quella materia",
		"Era troppo difficile",
		"Mi sono impegnato troppo poco",
		"Nessuno mi ha aiutato durante la prova",
		"Ero di cattivo umore o troppo in ansia",
		"Sono stato sfortunato",
	],
	[
		"Sono sempre disponibile verso di loro",
		"Mi ritengono simpatico",
		"Sono una persona estroversa e aperta",
		"La mia è una classe dove tutti si troverebbero bene",
		"Cerco sempre di capire il loro punto di vista",
		"I miei compagni sono sempre disponibili",
		"Solitamente sono di buon umore",
		"In genere le cose mi vanno bene",
	],
	[
		"Sono poco disponibile verso di loro",
		"Sono antipatici",
		"Sono chiuso/a e timido/a",
		"La mia è una classe dove chiunque si troverebbe male",
		"Non mi sforzo abbastanza per capire il loro punto di vista",
		"I miei compagni sono egoisti e poco disponibili",
		"Solitamente sono di cattivo umore",
		"Le cose in genere mi vanno male",
	],
	[
		"Partecipo sempre alle sue lezioni e sono disponibile",
		"Gli sono simpatico/a",
		"Sono una persona estroversa e aperta",
		"L’insegnante è tranquillo/a e poco esigente",
		"Cerco di capire cosa vuole che faccia e come vuole che mi comporti",
		"L’insegnante mi aiuta se mi vede in difficoltà",
		"Solitamente sono di buon umore",
		"Di solito ho fortuna",
	],
	[
		"Spesso mi comporto male",
		"Ce l’ha con me",
		"Sono chiuso/a e timido/a",
		"Ce l’hanno tutti con me",
		"Faccio poco o niente per avere un buon rapporto",
		"Non fa niente per venirmi incontro",
		"Sono spesso scontroso/a e di cattivo umore",
		"Non ho proprio fortuna",
	],
	[
		"Ci tengo molto ad avere un buon rapporto con lei",
		"Le sono simpatico/a",
		"Sono una persona estroversa e aperta",
		"È un tipo sereno e poco esigente",
		"Cerco di capire che cosa si aspetta da me",
		"Si mostra sempre disponibile nei miei confronti",
		"Solitamente sono di buon umore",
		"Di solito ho fortuna",
	],
	[
		"Spesso mi comporto male con lei",
		"Ce l’ha con me",
		"Sono chiuso/a e timido/a",
		"Ce l’hanno tutti con me",
		"Faccio poco o niente per avere un buon rapporto",
		"Non fa niente per venirmi incontro",
		"Sono spesso scontroso/a e di cattivo umore",
		"Non ho proprio fortuna",
	],
];

$count = count($questions);

\LogicManager\TestLogic::setParameterCount($count);

bump($questions);
bump($answers);
