<?php

//fetch class
$teacher = new Teacher(($this->get('user'))->id);

$grade = new Grade($teacher->classID);

//fetch sudents data
$studentsN = DB::count('users WHERE level=0 AND class = ?', [$grade->id]);
$activeN = DB::count('users WHERE level=0 AND status=1 AND class = ?', [$grade->id]);

$areasTot = DB::count('progress_areas WHERE progress=100 AND userID IN (SELECT id FROM users WHERE class = ? AND level=0 AND status=1)', [$grade->id]);
$areasPercent = $activeN ? round($areasTot / ($activeN * 3) * 100) : 0;

$sectionsTot = DB::count(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT id FROM users WHERE class = ? AND level=0 AND status=1)', [$grade->id]);

//setup sections
$sections = [
	[
		'title' => 'Lista degli studenti',
		'stitle' => '<strong>' . $studentsN . ' studenti</strong> di questa classe registrati',
		'desc' => 'Qui puoi controllare la lista degli studenti e confermare il loro accesso una volta che si registrano',
		'url' => client_url('/teacher/students'),
	],
	[
		'title' => 'Progresso per area',
		'stitle' => '<strong>' . $areasPercent . '%</strong> delle aree completate',
		'desc' => 'Qui puoi monitorare l\'andamento generale della classe nelle varie aree',
		'url' => client_url('/teacher/areas'),
	],
	[
		'title' => 'Progresso per attività',
		'stitle' => '<strong>' . $sectionsTot . '</strong> attività completate',
		'desc' => 'Qui puoi monitorare il progresso della classe diviso per attività',
		'url' => client_url('/teacher/sections'),
	],
	[
		'title' => 'Risultati complessivi',
		'stitle' => 'In sintesi',
		'desc' => 'Qui puoi controllare i risultati di ciascuno studente, una volta che avrà completato le attività proposte.',
		'url' => client_url('/teacher/results'),
	],
	[
		'title' => 'Modulistica',
		'stitle' => 'Documenti',
		'desc' => 'Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span> e del <span class="txt-sbold">Consiglio orientativo</span>.',
		'url' => client_url('/teacher/forms'),
	],
	[
		'title' => 'Saperne di più',
		'stitle' => 'Per approfondire',
		'desc' => 'Qui potrai accedere ad agili schede di approfondimento, arricchite da un Glossario ipertestuale.',
		'url' => client_url('/teacher/read'),
	],
	[
		'title' => 'Contattaci',
		'stitle' => 'Per dubbi o chiarimenti',
		'desc' => 'Se hai qualche dubbio sul funzionamento della piattaforma o hai qualche domanda puoi contattarci qui.',
		'url' => client_url('/teacher/contact'),
	],
];

bump($sections);

//set class as ended
if (isset($_POST['activate-survey'])) {

	DB::update('classes SET ended=1 WHERE id = ?', [$grade->id]);

	redirect();
}
