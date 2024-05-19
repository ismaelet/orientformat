<?php

use LogicManager\TestLogic;

$count = 0;
$parameterCount = [];
$results = test()->completed ? test()->rawResults : null;

$text = [
	['Le madri di quasi tutti i felini', 'chi'],
	[', gatti compresi, insegnano ai '],
	['cuccioli', 'chi'],
	[' l\'arte della caccia '],
	['con infinita pazienza', 'come'],
	[' e con un addestramento che dura anche diversi mesi', 'come'],
	['.<br><br>'],
	['La madre '],
	['inizia', 'quando'],
	[' portando nei pressi della "tana" una preda morta, di cui si ciba in presenza dei cuccioli. '],
	['Successivamente', 'quando'],
	[' porta loro una preda, sempre morta, di cui si potranno '],
	['cibare', 'scopo'],
	[', con cui potranno '],
	['giocare', 'scopo'],
	[' e '],
	['allenarsi', 'scopo'],
	[' mimando le varie tecniche di presa.<br><br>'],
	['La gatta passa poi alla '],
	['fase successiva', 'quando'],
	[', portando ai gattini prede tramortite, con cui possono '],
	['imparare i "placcaggi"', 'scopo'],
	['. '],
	['Alla fine', 'quando'],
	[', sottopone i piccoli alla prova più difficile, portando loro prede vive e quasi incolumi, sulle quali i gattini dovranno cercare, '],
	['non senza difficoltà', 'come'],
	[', di '],
	['aver la meglio', 'scopo'],
	['.<br><br>'],
	['Se è indubbio che '],
	['la spinta', 'causa'],
	[' a '],
	['imparare le tecniche di caccia', 'conseguenza'],
	[' dei piccoli è ben salda nel loro comportamento, anche '],
	['l\'istinto della madre', 'causa'],
	[' ad '],
	['insegnare loro a cacciare', 'conseguenza'],
	[' è così forte da trarre in inganno con i gatti con cui dividiamo le nostre case.<br><br>Ebbene, per qualche gatto, noi non siamo altro che dei teneri cuccioli cui insegnare come procurarsi il cibo.']
];

foreach ($text as $textPart) {
	if (isset($textPart[1])) {
		$textType = $textPart[1];

		$count++;

		if (!isset($parameterCount[$textType])) {
			$parameterCount[$textType] = 0;
		}

		$parameterCount[$textType]++;
	}
}

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$resultCount = 0;

			foreach ($_POST['field'] as $result) {
				if ($result) {
					$resultCount++;
				}
			}

			return round($resultCount / $count * 100);
		}
	);
