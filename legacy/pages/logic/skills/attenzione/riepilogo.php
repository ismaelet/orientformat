<?php

$legacyTest = test();

// setup variables
$answers = false;
$focus['score'] = 0;
$hyper['score'] = 0;

$sibling = $legacyTest->requiredTest;

$questions = [
	"Incontro difficoltà a dirigere l'attenzione sui dettagli o commetto errori di distrazione",
	"Spesso mi agito con le mani o i piedi o non riesco a stare fermo sulla sedia",
	"Incontro difficoltà nel mantenere l'attenzione nei compiti o nelle attività in cui sono impegnato",
	"Non riesco a stare seduto",
	"Quando mi si parla faccio fatica ad ascoltare",
	"Mi sento spesso irrequieto e non riesco a stare fermo",
	"Pur avendo capito le istruzioni e non avendo intenzioni ostili, non seguo le istruzioni avute o fatico a portarle a compimento",
	"Incontro difficoltà a impegnarmi attività tranquille",
	"Incontro difficoltà ad organizzarmi nei compiti e nelle mie attività",
	"Sento il bisogno di muovermi continuamente",
	"Evito o sono poco disposto a impegnarmi in attività che richiedono uno sforzo continuato",
	"Parlo eccessivamente",
	"Perdo oggetti necessari per le attività che devo svolgere",
	"Rispondo precipitosamente prima ancora che la domanda sia stata formulata interamente",
	"Vengo distratto facilmente da stimoli esterni",
	"Incontro difficoltà ad aspettare il mio turno",
	"Tendo a dimenticarmi di fare le cose",
	"Spesso interrompo gli altri impegnati in un gioco o in una conversazione",
];

$questN = count($questions);
$max = $questN * 2;

if ($sibling->completed) {

	$answers = [];

	foreach ($questions as $key => $question) {

		$answer = [];

		$answer['result'] = isset($sibling->rawResults[$key]) ? $sibling->rawResults[$key] + 1 : 0;
		$answer['critical'] = $answer['result'] > 2;
		$answer['question'] = $question;

		$answers[] = $answer;

		if ($key % 2) $hyper['score'] += $answer['result'];
		else $focus['score'] += $answer['result'];
	}

	bump($answers);

	$focus['width'] = $focus['score'] / $max * 100;
	$hyper['width'] = $hyper['score'] / $max * 100;

	$focus['critical'] = $focus['score'] > $max / 2;
	$hyper['critical'] = $hyper['score'] > $max / 2;
}
