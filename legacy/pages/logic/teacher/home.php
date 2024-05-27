<?php

use App\Models\Schools\SchoolClass;
use App\Models\Survey\SurveyHighschool_2024Result;
use Illuminate\Support\Facades\Auth;
use LegacyModels\Helpers\Notification;

$teacher = Auth::user()->teacher;

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

/**
 * ! TEMP FOR SURVEY
 */
$showSurvey = false;
$completedSurvey = false;
$surveyedSchools = [14, 40, 67, 77, 24];
$extraTeachers = [4677, 4912, 4914, 4915, 4917, 5393, 5394, 5840, 6031, 6032, 6033];

$teacherClassIds = $teacher->schoolClassIds;
$teacherSchoolClasses = SchoolClass::whereIn('id', $teacherClassIds)->where('startingGrade', '>', 3)->get();
$teacherSchools = $teacherSchoolClasses->pluck('schoolId')->unique();

if (count($teacherSchools) > 0) {
	$showSurvey = count(array_intersect($surveyedSchools, $teacherSchools->toArray())) > 0;
}

if (in_array(Auth::id(), $extraTeachers)) {
	$showSurvey = true;
}

if (SurveyHighschool_2024Result::where('teacher_id', Auth::id())->exists()) {
	$completedSurvey = true;
}
