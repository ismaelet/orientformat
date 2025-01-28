<?php

use Illuminate\Support\Facades\Auth;
use LegacyModels\Helpers\Notification;

$teacher = Auth::user()->teacher;
$teacherSchools = $teacher->schools();
$teacherSchoolIds = $teacherSchools->pluck('id')->toArray();

// setup page
$functionalities = [
	[
		'title' => 'Simulazione studente',
		'subtitle' => 'Per esplorare le attività',
		'desc' => 'Qui è possibile vedere quali saranno le attività proposte ai tuoi studenti e testare come funzionano.',
		'url' => client_url('/teacher/simulation'),
		'slug' => 'simulation'
	],
	[
		'title' => 'Saperne di più',
		'subtitle' => 'Per approfondire',
		'desc' => 'Qui potrai accedere ad agili schede di approfondimento, arricchite da un Glossario ipertestuale.',
		'url' => client_url('/teacher/know-more'),
		'slug' => 'know-more'
	],
	[
		'title' => 'Contattaci',
		'subtitle' => 'Per dubbi o chiarimenti',
		'desc' => 'Se hai qualche dubbio sul funzionamento della piattaforma o hai riscontrato qualche difficoltà, puoi contattarci qui.',
		'url' => client_url('/teacher/support/open-ticket'),
		'slug' => 'support'
	],
];

if (!in_array(78, $teacherSchoolIds)) {
	$functionalities[] =
		[
			'title' => 'Modulistica',
			'subtitle' => 'Documenti e informative',
			'desc' => 'Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span class="txt-sbold">Consiglio orientativo</span> e altri documenti di supporto.',
			'url' => client_url('/teacher/documents'),
			'slug' => 'documents'
		];
}

$functionalities[] =
	[
		'title' => 'Impostazioni account',
		'subtitle' => '',
		'desc' => 'Qui puoi cambiare i dati associati al tuo account e modificare le impostazioni di base.',
		'url' => client_url('/teacher/settings'),
		'slug' => 'settings'
	];

$feed = Notification::getAll([], 5);

// collaboration requests
$collaborations = \App\Legacy\LegacyDB::select('* FROM grade_requests WHERE referentId = ?', [Auth::id()]);

if (isset($_POST['accept-collaboration'])) {
	$collaborationId = $_POST['accept-collaboration'];
	$collaborationData = \App\Legacy\LegacyDB::row('* FROM grade_requests WHERE id = ?', [$collaborationId]);

	$gradeId = \App\Legacy\LegacyDB::update("teachers SET classes=CONCAT(classes, '," . $collaborationData['gradeId'] . "') WHERE userId = ?", [$collaborationData['teacherId']]);

	\App\Legacy\LegacyDB::delete('grade_requests WHERE id = ?', [$collaborationData['id']]);

	redirect_old();
}

if (isset($_POST['decline-collaboration'])) {
	$collaborationId = $_POST['decline-collaboration'];

	\App\Legacy\LegacyDB::delete('grade_requests WHERE id = ?', [$collaborationId]);

	redirect_old();
}
