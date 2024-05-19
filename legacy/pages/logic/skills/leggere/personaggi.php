<?php

use LogicManager\TestLogic;

$legacyTest = test();

$colors = ['c4', 'c1', 'c5', 'c2'];

$questions = [
	[
		'text' => 'Cane che non sei altro',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['disprezzo', 'ira', 'senso di superiorità'],
	],
	[
		'text' => 'Forse lui le tirerà in faccia le patate',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['divertimento', 'tristezza', 'sdegno'],
	],
	[
		'text' => 'L\'ansimo del suo torace di bambino, un sibilare che scaturisce dalle canne gracili dei suoi polmoni',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['paura', 'derisione', 'dolore'],
	],
	[
		'text' => 'La mano della padrona si alza ancora minacciosa',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['paura', 'rabbia', 'angoscia'],
	],
	[
		'text' => 'Le fece un bell\'inchino, accennò un baciamano, tolse di tasca un biglietto da 10 scellini',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['ira', 'sdegno', 'paura', 'serenità', 'allegria', 'ironia'],
	],
	[
		'text' => 'Lo prese spaventata',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['smarrimento', 'ira', 'terrore', 'stupore'],
	],
	[
		'text' => 'Disse con buona creanza',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['senso di inferiorità', 'senso di superiorità', 'ironia'],
	],
	[
		'text' => 'Si fece silenzio',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['stupore', 'paura', 'allegria'],
	],
	[
		'text' => 'Posso altresì attirare la sua benigna attenzione sul fatto che è venuta l\'ora delle funzioni? La prego di porgere al signor parroco i miei più rispettosi saluti',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['sarcasmo', 'paura', 'fraternità'],
	],
	[
		'text' => 'Scesero le lacrime',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['vergogna', 'tristezza', 'angoscia', 'smarrimento'],
	],
	[
		'text' => 'Le sue grida',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['ira', 'imbarazzo', 'disagio', 'gioia'],
	],
	[
		'text' => 'Dov\'era quell\'ubriaco torvo e insanguinato… Si era forse buttato nello Shannon?',
		'answers' => ['ubriaco', 'padrona', 'ragazzo', 'narratore'],
		'emotions' => ['ironia', 'tristezza', 'malinconia', 'angoscia'],
	],
];

$answers = [2, 4, 3, 2, 1, 2, 1, 2, 1, 2, 2, 4];
$answers_emotions = [
	[2],
	[3],
	[1],
	[2],
	[2, 4],
	[1, 4],
	[1, 3],
	[1],
	[1],
	[1, 4],
	[2, 3],
	[2, 3],
];

$results_emotions = explode(',', \Legacy\System\Classes\LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), $legacyTest->id]));

$count = count($questions) * 2;

bump($questions);

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$rightN = 0;
		$answers = \Legacy\System\Classes\LegacyView::getInstance()->get('answers');
		$answers_emotions = \Legacy\System\Classes\LegacyView::getInstance()->get('answers_emotions');

		$results = implode(',', $_POST['field_other']);

		\Legacy\System\Classes\LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [\Illuminate\Support\Facades\Auth::id(), testId()]);
		\Legacy\System\Classes\LegacyDB::add('results_others (userID, testID, result) VALUES (?, ?, ?)', [\Illuminate\Support\Facades\Auth::id(), testId(), $results]);

		foreach ($_POST['field'] as $key => $field) {
			if ($field == $answers[$key]) {
				$rightN++;
			}
		}

		foreach ($_POST['field_other'] as $key => $field) {
			$valid = true;
			$values = explode('+', $field);
			$emotions = $answers_emotions[$key];

			foreach ($values as $val) {
				if (!in_array($val, $emotions)) {
					$valid = false;
				}
			}

			foreach ($emotions as $emotion) {
				if (!in_array($emotion, $values)) {
					$valid = false;
				}
			}

			if ($valid) $rightN++;
		}

		return round($rightN / $count * 100);
	});
