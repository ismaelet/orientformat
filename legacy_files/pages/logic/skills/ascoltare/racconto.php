<?php

use LogicManager\TestLogic;

$test = test();

$results = [];

$questions = $questions ?? [
	"La vicenda è ambientata",
	"Il THOLOS è",
	"In che periodo dell’anno si svolge il fatto",
	"Il padre e il nonno di Giovanni erano",
	"Qual è la corretta successione dei fatti",
	"Il lupo dal pelo argentato era",
	"Le prime parole del lupo sono",
	"L’uomo ha saccheggiato l’ambiente del lupo e ha lasciato solo",
	"Cos’è successo realmente a Giovanni",
	"Il messaggio che vuole trasmetterci l’autore è",
];

$answers = $answers ?? [
	[
		'res' => ["sugli Appennini tosco‐emiliani", "sull’Altopiano della Sila", "sulle Alpi", "sugli Appennini abruzzesi"],
		'right' => 4
	],
	[
		'res' => ["metà grotta e metà capanna", "metà ovile e metà trullo", "metà baita e metà rifugio", "un ovile circondato da un muretto a secco"],
		'right' => 2
	],
	[
		'res' => ["in estate", "nel periodo autunnale", "in inverno", "allo scioglimento delle nevi"],
		'right' => 1
	],
	[
		'res' => ["cacciatori", "boscaioli", "contadini", "pastori"],
		'right' => 4
	],
	[
		'res' => ["a. mette le tagliole, b. i morsi della la fame, c. le due pecore uccise, d. Giovanni capisce, e. il corpo si trasforma, f. incontro col lupo", "a. i morsi della la fame, b. incontro col lupo, c. le due pecore uccise, d. mette le tagliole, e. Giovanni capisce, f. il corpo si trasforma", "a. le due pecore uccise, b. mette le tagliole, c. incontro col lupo, d. il corpo si trasforma, e. i morsi della la fame, f. Giovanni capisce", "a. le due pecore uccise, b. mette le tagliole, c. incontro col lupo, d. i morsi della la fame, e. il corpo si trasforma, f. Giovanni capisce"],
		'right' => 3
	],
	[
		'res' => ["Fiero, immobile, tranquillo", "Minaccioso e vendicativo", "Mansueto e docile", "Scaltro e dispettoso"],
		'right' => 1
	],
	[
		'res' => ["“Uccidere è difficile, capire è più facile”", "“Uccidere è sbagliato ma necessario”", "“Uccidere è facile, capire è più difficile”", "“Uccidere è questione d’istinto”"],
		'right' => 3
	],
	[
		'res' => ["erbacce e qualche pecora", "immondizia e qualche agnello da rubare", "boschi e avanzi di cibo", "ovili da saccheggiare"],
		'right' => 2
	],
	[
		'res' => ["Cadendo, ha battuto la testa ed ha sognato tutto", "Non si è mai spostato dal suo tholos", "Complice la luna piena, si è trasformato effettivamente in lupo‐mannaro", "Ha subito un incantesimo"],
		'right' => 1
	],
	[
		'res' => ["Bisogna proteggere l’ambiente da inquinamento e rifiuti", "Il lupo uccide solo per la propria sopravvivenza e non per crudeltà", "È crudele posare tagliole", "Andare per i boschi di notte è pericoloso"],
		'right' => 2
	],
];

foreach ($questions as $questionKey => $question) {
	$questionData = [];
	$questionData['text'] = $questions[$questionKey];

	foreach ($answers[$questionKey]['res'] as $answerKey => $answer) {
		$answerData = [];
		$answerData['text'] = $answer;
		$answerData['checked'] = isset($test->rawResults[$questionKey]) && $test->rawResults[$questionKey] == $answerKey + 1;

		if ($test->completed && $answerData['checked']) {
			$answerData['class'] = $answerKey + 1 == $answers[$questionKey]['right'] ? 'right' : 'wrong';
		} else {
			$answerData['class'] = '';
		}

		$questionData['answers'][] = $answerData;
	}

	$content[] = $questionData;
}

$count = count($questions);

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$answers = ViewOld::getInstance()->get('answers');

		$rightN = 0;

		foreach ($_POST['field'] as $key => $value) {
			if ($value == $answers[$key]['right']) $rightN++;
		}

		return round($rightN / $count * 100);
	});
