<?php

//theme
$this->styles->add(SERVER_ROOT . '/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT . '/pages/scripts/teacher/teacher.js');

//get variables
$id = $_GET['id'] ?? false;


//fetch class
$grade = \System\Classes\DBOld::find('class FROM users WHERE id = ?', [$user->id]);

//fetch student data
$student = \System\Classes\DBOld::row('* FROM users WHERE level=0 AND status=1 AND id = ? AND class = ?', [$id, $grade]);

if (!$student) redirect_old('/teacher/results');

//fetch areas and sections
$areas = [];

$res = \System\Classes\DBOld::select('id, name FROM areas WHERE id<4 ORDER BY id ASC');

while ($row = $res->fetch_assoc()) {

	$sections = \System\Classes\DBOld::select('* FROM sections WHERE active=1 AND locked=0 AND id NOT IN (6, 18) AND area = ? ORDER BY id ASC', [$row['id']]);

	$area['name'] = $row['name'];
	$area['sections'] = $sections;

	$areas[] = $area;
}

bump($areas);

//calculate the results
$results = [];

//Stili cognitivi
$res = \System\Classes\DBOld::find('result FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, 30]);

if ($res) {

	$groups = [
		'Visivo',
		'Collaborativo',
		'Globale',
		'Intuitivo',
		'Uditivo',
		'Autonomo',
		'Analitico',
		'Sistematico',
	];

	bump($groups);

	$max = 0;

	$result = [];

	$res = explode(',', $res);

	foreach ($res as $key => $val) {

		switch (true) {
			case in_array($key, [3, 9, 13]):
				$group = 1;
				break;
			case in_array($key, [6, 10, 19]):
				$group = 2;
				break;
			case in_array($key, [5, 11, 16]):
				$group = 3;
				break;
			case in_array($key, [7, 15, 22]):
				$group = 4;
				break;
			case in_array($key, [1, 18, 23]):
				$group = 5;
				break;
			case in_array($key, [0, 12, 21]):
				$group = 6;
				break;
			case in_array($key, [2, 4, 17]):
				$group = 7;
				break;
			case in_array($key, [8, 14, 20]):
				$group = 8;
				break;
		}

		if (!isset($result[$group])) $result[$group] = 0;

		$result[$group] += $val;
	}

	arsort($result);

	$results[] = 'Stile prevalente: <strong>' . strtolower($groups[array_key_first($result)]) . '</strong>';
} else $results[] = false;

//Resilienza
$res = \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, 49]);

if ($res) {

	$titles = ['pochissima', 'poca', 'abbastanza', 'molta', 'moltissima'];

	bump($titles);

	$score = round($res / 25) + 1;

	$results[] = 'Risultato: <strong>' . $titles[$score] . '</strong>';
} else $results[] = false;

//Autostima
$completed = true;

$tests = \System\Classes\DBOld::select('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND static=0 AND template<>"recap"', [4]);

while ($test = $tests->fetch_assoc()) if (!\System\Classes\DBOld::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, $test['id']])) $completed = false;

if ($completed) {

	$tot = \System\Classes\DBOld::sum('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND id<?)', [$id, 4, 15]);
	$compN = \System\Classes\DBOld::count(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND completed=1 AND testID IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND id<?)', [$id, 4, 15]);

	$tot = round($tot / $compN, 0);

	$results[] = 'Risultato: <strong>' . $tot . '%' . '</strong>';
} else $results[] = false;

//Risolvere i problemi
$res = \System\Classes\DBOld::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, 13]);

if ($res) {

	$tot = \System\Classes\DBOld::sum('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND completed=1 AND testID IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND template<>"recap" AND active=1 AND id<>1)', [$id, 5]);
	$compN = \System\Classes\DBOld::count('tests WHERE sectionID=5 AND template<>"recap" AND active=1 AND id<>1');

	$tot = round($tot / $compN, 0);

	$results[] = 'Risultato: <strong>' . $tot . '%' . '</strong>';
} else $results[] = false;

//Motivazione
$completed = true;

$tests = \System\Classes\DBOld::select('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND static=0 AND template<>"recap"', [7]);

while ($test = $tests->fetch_assoc()) if (!\System\Classes\DBOld::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, $test['id']])) $completed = false;

if ($completed) {

	$res = \System\Classes\DBOld::find('result FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, 19]);

	$res = explode(',', $res);

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
		'area tecnico-organizzativa',
		'area naturalistica',
		'area figurativo-spaziale',
		'area logico-matematica',
		'area esistenziale',
		'area musicale',
		'area verbale-interpersonale',
		'area motoria',
		'area tecnico-organizzativa',
		'area naturalistica',
		'area figurativo-spaziale',
		'area logico-matematica',
		'area esistenziale',
		'area musicale',
		'area verbale-interpersonale',
		'area motoria',
	];

	bump($titles);

	$result = [0, 0, 0, 0, 0, 0, 0, 0];

	bump($result);

	foreach ($questions as $key => $question) {

		$result[$question[1]] += $res[$key];
	}

	arsort($result);

	$results[] = 'Area di interesse principale: <strong>' . $titles[array_key_first($result)] . '</strong>';
} else $results[] = false;

//Temperamento
$completed = true;

$tests = \System\Classes\DBOld::select('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND static=0 AND template<>"recap"', [8]);

while ($test = $tests->fetch_assoc()) if (!\System\Classes\DBOld::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [$id, $test['id']])) $completed = false;

if ($completed) {

	$sections = ['stabilità emotiva', 'estroversione', 'socievolezza', 'coscienziosità', 'risposta alle novità'];

	$result = [];

	for ($i = 1; $i < 6; $i++) {

		$val = (int) \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionID=8 AND step = ?)', [$id, $i]);

		$result[] = round($val / 100 * 6);
	}

	arsort($result);

	$results[] = 'Aspetto del temperamento predominante: <strong>' . $sections[array_key_first($result)] . '</strong>';
} else $results[] = false;

//Competenze e saperi
for ($i = 9; $i < 18; $i++) {

	if ($i != 16) {

		$res = \System\Classes\DBOld::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ?)', [$id, $i]);

		if ($res) {

			$score = 0;
			$tests = \System\Classes\DBOld::select('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND static=0 AND template<>"recap"', [$i]);
			$total = \System\Classes\DBOld::count('tests WHERE sectionId = ? AND static=0 AND template<>"recap"', [$i]);

			while ($test = $tests->fetch_assoc()) $score += \System\Classes\DBOld::find('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ? ORDER BY time DESC', [$id, $test['id']]) ?: 0;

			$percent = round($score / $total, 0);

			$results[] = 'Risultato: <strong>' . $percent . '%</strong>';
		} else $results[] = false;

		$infos[$i] = 'La media dei risultati ottenuti nelle varie attività di questa sezione.';
	}
}

//store results
bump($results);

//infos
$infos[1] = 'Risultati possibili: visivo, uditivo, autonomo, collaborativo, globale, analitico, intuitivo e sistematico.';
$infos[3] = 'In una scala da pochissima a moltissima.';
$infos[4] = 'La media dei risultati nelle varie aree.';
$infos[5] = 'La media dei risultati ottenuti nei vari esercizi. Non include il punteggio ottenuto nell\'autovalutazione.';
$infos[7] = 'Possibili aree di interesse: tecnico-organizzativa, naturalistica, figurativo-spaziale, logico-matematica, verbale-interpersonale, musicale, esistenziale, motoria.';
$infos[8] = 'I vari aspetti possibili sono: stabilità emotiva, estroversione, socievolezza, coscienziosità e risposta alle novità.';
$infos[17] = 'La media delle autovalutazioni effettuate.';
