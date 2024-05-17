<?php

use LegacyModels\Helpers\Notification;

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
	[
		'title' => 'Modulistica',
		'subtitle' => 'Documenti e informative',
		'desc' => 'Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span class="txt-sbold">Consiglio orientativo</span> e altri documenti di supporto.',
		'url' => client_url('/teacher/documents'),
		'slug' => 'documents'
	],
	[
		'title' => 'Impostazioni account',
		'subtitle' => '',
		'desc' => 'Qui puoi cambiare i dati associati al tuo account e modificare le impostazioni di base.',
		'url' => client_url('/teacher/settings'),
		'slug' => 'settings'
	],
];

$feed = Notification::getAll([], 8);

// collaboration requests
$collaborations = \System\Classes\DBOld::select('* FROM grade_requests WHERE referentId = ?', [teacherId()]);

if (isset($_POST['accept-collaboration'])) {
	$collaborationId = $_POST['accept-collaboration'];
	$collaborationData = \System\Classes\DBOld::row('* FROM grade_requests WHERE id = ?', [$collaborationId]);

	$gradeId = \System\Classes\DBOld::update("teachers SET classes=CONCAT(classes, '," . $collaborationData['gradeId'] . "') WHERE userId = ?", [$collaborationData['teacherId']]);

	\System\Classes\DBOld::delete('grade_requests WHERE id = ?', [$collaborationData['id']]);

	redirect_old();
}

if (isset($_POST['decline-collaboration'])) {
	$collaborationId = $_POST['decline-collaboration'];

	\System\Classes\DBOld::delete('grade_requests WHERE id = ?', [$collaborationId]);

	redirect_old();
}
