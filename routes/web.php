<?php

use App\Http\Controllers\Activities\GradeController;
use App\Http\Controllers\Activities\StudentAnalysisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Controllers\SurveysHighschool2024Controller;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Student;
use App\Http\Middleware\Teacher;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * * App routes
 */
// ~ Home
Route::get('', [HomeController::class, 'index'])->middleware('auth')->name('home');

// ~ Surveys
Route::get('2024-highschool-survey', [SurveysHighschool2024Controller::class, 'index'])->name('2024-highschool-survey')->middleware(Teacher::class);

Route::post('2024-highschool-survey', [SurveysHighschool2024Controller::class, 'store'])->middleware(Teacher::class);

/**
 * * Workarounds
 */
Route::get('run-migrations', function () {
	Artisan::call('migrate', [
		'--force' => true
	]);
})->middleware(Admin::class);

Route::get('dump-autoload', function () {
	$output = shell_exec('composer dump-autoload');
	dd($output);
})->middleware(Admin::class);

Route::get('composer-install', function () {
	$output = shell_exec('composer install');
	dd($output);
})->middleware(Admin::class);

/**
 * * Parcially legacy routes
 */
// ~ Home pages
Route::any('student', [StudentHomeController::class, 'index'])->middleware(Student::class)->name('student');

Route::any('teacher-dashboard', [TeacherDashboardController::class, 'index'])->middleware(Teacher::class)->name('teacher.dashboard');

// ~ Student Activities
Route::any('activities/grades', [GradeController::class, 'index'])->middleware([Student::class])->name('activities.grades.index');
Route::any('activities/grades/{grade}', [GradeController::class, 'show'])->middleware([Student::class])->name('activities.grades.show');

// ~ Student Analisys
Route::any('analysis/student/areas/{area}', [StudentAnalysisController::class, 'show'])->middleware(['auth'])->name('analysis.student.area');
Route::any('analysis/student/sections/{section}', [StudentAnalysisController::class, 'show'])->name('analysis.student.section');

Route::get('logout', LegacyController::class)->name('logout');


// ****************

Route::get('results', function () {
	$results = [
		'{"A-1":"Coordinatore\/Coordinatrice del Consiglio di classe","A-2-Profilo_personale-A":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-B":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-C":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-D":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-E":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-F":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-G":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-H":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-I":"Utilizzata in pi\u00f9 classi","A-2-Profilo_personale-J":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-A":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-B":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-C":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-D":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-E":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-F":"Utilizzata in pi\u00f9 classi","A-2-Competenze_di_base-G":"Utilizzata in pi\u00f9 classi","A-2-Saperi_informali-A":"Utilizzata in una sola classe","A-2-Saperi_informali-B":"Utilizzata in una sola classe","A-2-Scegliere-A":"Utilizzata in una sola classe","A-2-Scegliere-B":"Utilizzata in una sola classe","B-1":"Tutta la classe","B-2":"Generalmente molto","C-1":"Ha interessato e coinvolto altri colleghi del Consiglio di classe","C-2":"Ha influito in qualche modo sulla didattica in alcune discipline","D-1-A":"Molto","D-1-B":"Molto","D-1-C":"Molto","D-1-D":"Molto","D-1-E":"Molto","D-2-A":"Abbastanza","D-2-B":"Abbastanza","D-2-C":"Per niente","D-2-D":"Per niente","D-2-E":"Abbastanza","D-2-F":"Per niente","D-3-A":"Abbastanza","D-3-B":"Abbastanza","D-3-C":"Abbastanza","D-3-D":"Abbastanza","D-3-E":"Abbastanza","D-4-A":"Molto","D-4-B":"Abbastanza","D-4-C":"Abbastanza","D-4-D":"Molto","D-4-E":"Per niente","D-5-A":"Molto","D-5-B":"Molto","D-5-C":"Molto","D-5-D":"Abbastanza","D-5-E":"Poco","D-6-A":"Abbastanza","D-6-B":"Abbastanza","D-6-C":"Poco","D-6-D":"Poco","D-6-E":"Abbastanza","D-7-A":"Molto","D-7-B":"Abbastanza","D-7-C":"Abbastanza","D-7-D":"Abbastanza","D-8-A":"Abbastanza","D-8-B":"Abbastanza","D-8-C":"Abbastanza","D-8-D":"Abbastanza","D-9-A":"Molto","D-9-B":"Molto","D-9-C":"Poco","D-9-D":"Molto","D-10-A":"Abbastanza","D-10-B":"Molto","D-10-C":"Abbastanza","D-10-D":"Abbastanza","D-10-E":"Abbastanza","D-11-A":"Abbastanza","D-11-B":"Abbastanza","D-11-C":"Abbastanza","D-11-D":"Abbastanza","E-1-A":"Molto","E-1-B":"Molto","E-1-C":"Per niente","E-1-D":"Per niente","E-1-E":"Molto","E-2-A":"Molto","E-2-B":"Molto","E-2-C":"Molto","E-2-D":"Molto","E-2-E":"Molto","E-3-A":"Molto","E-3-B":"Per niente","E-3-C":"Molto","E-3-D":"Molto","F-1-A":"profilo personale stile attributivo","F-1-B":"profilo personale stili cognitivi","F-1-C":"profilo personale motivazione e aree di interesse","F-1-D":"profilo personale emozioni","F-1-E":"profilo personale problem solving","F-2-A":"competenze di base imparare","F-2-B":"competenze di base leggere","F-4-A":"visibilit\u00e0 nominativi docenti presenti in una classe","F-4-B":"possibilit\u00e0 di stampa riepilogo classe","F-4-C":"possibilit\u00e0 di stampa riepilogo alunno","F-5":"S\u00ec"}',

		'{"A-1":["Docente di scuola media","Coordinatore\/Coordinatrice del Consiglio di classe"],"A-2-Profilo_personale-A":"Utilizzata in una sola classe","A-2-Profilo_personale-B":"Utilizzata in una sola classe","A-2-Profilo_personale-C":"Utilizzata in una sola classe","A-2-Profilo_personale-D":"Utilizzata in una sola classe","A-2-Profilo_personale-E":"Utilizzata in una sola classe","A-2-Profilo_personale-F":"Utilizzata in una sola classe","A-2-Profilo_personale-G":"Utilizzata in una sola classe","A-2-Profilo_personale-H":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Profilo_personale-J":"Utilizzata in una sola classe","A-2-Saperi_informali-A":"Utilizzata in una sola classe","A-2-Scegliere-A":"Utilizzata in una sola classe","B-1":"Tutta la classe","B-2":"Molto alcuni e poco altri","C-1":"Ha interessato e coinvolto altri colleghi del Consiglio di classe","C-2":"Ha influito in qualche modo sulla didattica in alcune discipline","C-3":"Non ha avuto nessun raccordo con l\u2019alternanza scuola-lavoro","D-1-A":"Molto","D-1-B":"Molto","D-1-E":"Molto","D-2-G":"Abbastanza","D-3-A":"Molto","D-3-B":"Molto","D-3-C":"Molto","D-3-D":"Abbastanza","D-3-E":"Poco","D-4-F":"Abbastanza","D-5-A":"Molto","D-5-B":"Molto","D-5-C":"Molto","D-6-A":"Molto","D-6-B":"Molto","D-6-C":"Abbastanza","D-6-D":"Poco","D-6-E":"Molto","D-7-E":"Abbastanza","D-8-A":"Molto","D-8-B":"Molto","D-8-C":"Molto","D-8-D":"Molto","D-9-A":"Molto","D-9-B":"Molto","D-9-C":"Poco","D-9-D":"Molto","D-10-F":"Abbastanza","D-11-B":"Molto","D-11-D":"Molto","E-1-A":"Molto","E-1-C":"Abbastanza","E-1-D":"Per niente","E-1-E":"Molto","E-2-A":"Molto","E-2-B":"Molto","E-2-C":"Molto","E-2-D":"Abbastanza","E-2-E":"Molto","E-3-A":"Molto","E-3-C":"Abbastanza","E-3-D":"Abbastanza","F-1-A":"Proporre attivit\u00e0 di metacognizione","F-1-B":"aiutarli a capire alcune loro caratteristiche","F-1-C":"distribuire il percorso in pi\u00f9 anni","F-2-A":"difficolt\u00e0 a coinvolgere pi\u00f9 docenti per condividere\/suddividere la proposta","F-5":"S\u00ec"}',
		'{"A-1":["Docente di scuola media","Coordinatore\/Coordinatrice del Consiglio di classe"],"A-2-Profilo_personale-E":"Utilizzata in una sola classe","A-2-Profilo_personale-G":"Utilizzata in una sola classe","A-2-Profilo_personale-H":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Competenze_di_base-E":"Utilizzata in una sola classe","A-2-Competenze_di_base-F":"Utilizzata in una sola classe","A-2-Competenze_di_base-G":"Utilizzata in una sola classe","B-1":"Tutta la classe","B-2":"Generalmente molto","C-1":"\u00c8 stata praticamente ignorata","C-2":"Ha influito in qualche modo sulla didattica in alcune discipline","D-1-A":"Molto","D-1-B":"Abbastanza","D-1-C":"Molto","D-1-D":"Abbastanza","D-1-E":"Molto","D-2-A":"Molto","D-2-B":"Molto","D-2-G":"Molto","D-3-A":"Molto","D-3-B":"Molto","D-3-C":"Molto","D-3-D":"Molto","D-3-E":"Abbastanza","D-4-A":"Abbastanza","D-4-B":"Abbastanza","D-4-E":"Abbastanza","D-5-F":"Molto","D-6-E":"Molto","D-7-E":"Molto","D-8-A":"Molto","D-8-B":"Abbastanza","D-8-C":"Molto","D-8-D":"Molto","D-9-A":"Molto","D-9-B":"Abbastanza","D-9-C":"Abbastanza","D-9-D":"Molto","D-10-A":"Abbastanza","D-10-B":"Abbastanza","D-10-C":"Abbastanza","D-10-D":"Abbastanza","D-10-E":"Molto","D-11-E":"Molto","E-1-A":"Abbastanza","E-1-B":"Abbastanza","E-1-E":"Abbastanza","E-2-A":"Molto","E-2-B":"Abbastanza","E-2-C":"Molto","E-2-D":"Molto","E-2-E":"Molto","E-3-A":"Abbastanza","E-3-C":"Abbastanza","E-3-D":"Molto","F-1-A":"Profilo personale - Motivazione e aree di interesse","F-1-B":"Profilo personale - Stile attributivo","F-1-C":"Competenze di base - Ricordare","F-1-D":"Profilo personale - Risolvere problemi","F-1-E":"Profilo personale - Resilienza","F-5":"S\u00ec"}',
		'{"A-1":["Docente di scuola media"],"A-2-Profilo_personale-A":"Utilizzata in una sola classe","A-2-Profilo_personale-B":"Utilizzata in una sola classe","A-2-Profilo_personale-F":"Utilizzata in una sola classe","A-2-Profilo_personale-H":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Profilo_personale-J":"Utilizzata in una sola classe","A-2-Competenze_di_base-A":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Competenze_di_base-C":"Utilizzata in una sola classe","A-2-Competenze_di_base-D":"Utilizzata in una sola classe","A-2-Competenze_di_base-E":"Utilizzata in una sola classe","A-2-Competenze_di_base-F":"Utilizzata in una sola classe","A-2-Competenze_di_base-G":"Utilizzata in una sola classe","A-2-Scegliere-A":"Utilizzata in una sola classe","B-1":"Tutta la classe","B-2":"Generalmente molto","C-1":"Ha interessato e coinvolto altri colleghi del Consiglio di classe","C-2":"Ha influito in qualche modo sulla didattica in alcune discipline","C-3":"Non ha avuto nessun raccordo con l\u2019alternanza scuola-lavoro","D-1-A":"Molto","D-1-B":"Molto","D-1-C":"Molto","D-1-D":"Molto","D-1-E":"Molto","D-2-A":"Abbastanza","D-2-B":"Abbastanza","D-2-C":"Abbastanza","D-2-D":"Abbastanza","D-2-E":"Abbastanza","D-2-F":"Poco","D-2-G":"Poco","D-3-A":"Abbastanza","D-3-B":"Abbastanza","D-3-C":"Molto","D-3-D":"Molto","D-3-E":"Abbastanza","D-3-F":"Poco","D-4-F":"Abbastanza","D-5-F":"Abbastanza","D-6-A":"Abbastanza","D-6-B":"Abbastanza","D-6-C":"Abbastanza","D-6-D":"Abbastanza","D-6-E":"Abbastanza","D-7-A":"Abbastanza","D-7-B":"Abbastanza","D-7-C":"Abbastanza","D-7-D":"Abbastanza","D-7-E":"Poco","D-8-A":"Abbastanza","D-8-B":"Abbastanza","D-8-C":"Abbastanza","D-8-D":"Abbastanza","D-8-E":"Poco","D-9-A":"Abbastanza","D-9-B":"Abbastanza","D-9-C":"Abbastanza","D-9-D":"Abbastanza","D-9-E":"Poco","D-10-A":"Abbastanza","D-10-B":"Molto","D-10-C":"Molto","D-10-D":"Abbastanza","D-10-E":"Molto","D-10-F":"Poco","D-11-A":"Abbastanza","D-11-B":"Molto","D-11-C":"Abbastanza","D-11-D":"Abbastanza","D-11-E":"Poco","E-1-A":"Molto","E-1-B":"Molto","E-1-C":"Abbastanza","E-1-D":"Poco","E-1-E":"Molto","E-2-A":"Molto","E-2-B":"Molto","E-2-C":"Molto","E-2-D":"Abbastanza","E-2-E":"Molto","E-3-A":"Abbastanza","E-3-B":"Poco","E-3-C":"Molto","E-3-D":"Molto","F-5":"S\u00ec"}',
		'{"A-1":["Docente di scuola superiore","Coordinatore\/Coordinatrice del Consiglio di classe"],"A-2-Profilo_personale-A":"Utilizzata in una sola classe","A-2-Profilo_personale-B":"Utilizzata in una sola classe","A-2-Profilo_personale-E":"Utilizzata in una sola classe","A-2-Profilo_personale-F":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Competenze_di_base-A":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Saperi_informali-B":"Utilizzata in una sola classe","A-2-Scegliere-A":"Utilizzata in una sola classe","B-1":"La maggior parte della classe","B-2":"Generalmente abbastanza","C-1":"Ha interessato e coinvolto altri colleghi del Consiglio di classe","C-2":"Non ha influito in alcun modo sulla didattica disciplinare","C-3":"Non ha avuto nessun raccordo con l\u2019alternanza scuola-lavoro","D-1-A":"Poco","D-1-B":"Abbastanza","D-1-C":"Abbastanza","D-1-D":"Molto","D-1-E":"Abbastanza","D-2-A":"Molto","D-2-B":"Abbastanza","D-2-C":"Abbastanza","D-2-D":"Abbastanza","D-2-E":"Abbastanza","D-2-F":"Abbastanza","D-2-G":"Poco","D-3-A":"Abbastanza","D-3-B":"Poco","D-3-C":"Abbastanza","D-3-D":"Poco","D-3-E":"Abbastanza","D-3-F":"Per niente","D-4-A":"Poco","D-4-B":"Poco","D-4-C":"Abbastanza","D-4-D":"Abbastanza","D-4-E":"Abbastanza","D-4-F":"Per niente","D-5-A":"Poco","D-5-B":"Poco","D-5-C":"Poco","D-5-D":"Abbastanza","D-5-E":"Per niente","D-5-F":"Per niente","D-6-A":"Poco","D-6-B":"Poco","D-6-C":"Abbastanza","D-6-D":"Poco","D-6-E":"Molto","D-7-A":"Poco","D-7-B":"Abbastanza","D-7-C":"Abbastanza","D-7-D":"Abbastanza","D-7-E":"Per niente","D-8-A":"Molto","D-8-B":"Molto","D-8-C":"Molto","D-8-D":"Molto","D-8-E":"Per niente","D-9-A":"Molto","D-9-B":"Abbastanza","D-9-C":"Poco","D-9-D":"Abbastanza","D-9-E":"Per niente","D-10-A":"Molto","D-10-B":"Molto","D-10-C":"Molto","D-10-D":"Poco","D-10-E":"Abbastanza","D-10-F":"Per niente","D-11-A":"Abbastanza","D-11-B":"Abbastanza","D-11-C":"Abbastanza","D-11-D":"Abbastanza","D-11-E":"Abbastanza","E-1-A":"Abbastanza","E-1-B":"Abbastanza","E-1-C":"Abbastanza","E-1-D":"Poco","E-1-E":"Abbastanza","E-2-A":"Abbastanza","E-2-B":"Molto","E-2-C":"Molto","E-2-D":"Molto","E-2-E":"Molto","E-3-A":"Molto","E-3-B":"Poco","E-3-C":"Molto","E-3-D":"Molto","F-1-A":"L\'attenzione all\'aspetto psicologico","F-1-B":"Lo studio della capacità di ascolto in un mondo dove si sente tanto ma si ascolta poco","F-2-A":"Il fatto che non sempre una piattaforma viene presa seriamente dagli studenti (molti hanno risposto a caso o lo hanno preso come gioco)","F-2-B":"Il fatto che non ci si concentra molto sui problemi personali degli studenti che spesso sono alla base dell\'abbandono scolastico","F-2-C":"Il fatto che sia uno strumento visto in modo abbastanza passivo dagli studenti (per quando si prevedano esercizi o test, sono comunque prove in cui devi stare al pc seduto)","F-2-D":"Il fatto che le famiglie possono- se vogliono- non impegnarsi per niente nel progetto.","F-3-A":"Nessuna","F-4-A":"Coinvolgimento attivo (anche tramite incontri) delle famiglie.","F-4-B":"Incontri con qualche psicologo\/esperto che aiuti i ragazzi nell\'elaborazione delle risposte.","F-4-C":"Parti pratiche in cui gli studenti abbiano modo di vedere se quello che pensano di sè è vero (es. se uno studente dice di essere bravo nelle attivit\u00e0 manuali, la piattaforma potrebbe lanciare una sfida per far vedere allo studente se effettivamente è capace).","F-5":"Sì"}',
		'{"A-1":["Docente di scuola superiore","Referente per l\u2019orientamento"],"A-2-Profilo_personale-B":"Utilizzata in una sola classe","A-2-Profilo_personale-G":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Competenze_di_base-A":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Competenze_di_base-C":"Utilizzata in una sola classe","A-2-Competenze_di_base-D":"Utilizzata in una sola classe","A-2-Competenze_di_base-E":"Utilizzata in una sola classe","A-2-Competenze_di_base-F":"Utilizzata in una sola classe","A-2-Competenze_di_base-G":"Utilizzata in una sola classe","A-2-Saperi_informali-B":"Utilizzata in una sola classe","B-1":"La maggior parte della classe","B-2":"Generalmente molto","C-1":"Ha interessato e coinvolto altri colleghi del Consiglio di classe","C-2":"Ha influito in qualche modo sulla didattica in alcune discipline","C-3":"Non ha avuto nessun raccordo con l\u2019alternanza scuola-lavoro","D-1-A":"Abbastanza","D-1-B":"Abbastanza","D-1-C":"Molto","D-1-D":"Abbastanza","D-1-E":"Molto","D-2-A":"Abbastanza","D-2-B":"Abbastanza","D-2-C":"Per niente","D-2-D":"Poco","D-2-E":"Molto","D-2-F":"Poco","D-3-A":"Molto","D-3-B":"Molto","D-3-C":"Molto","D-3-D":"Molto","D-3-E":"Molto","D-4-A":"Molto","D-4-B":"Molto","D-4-C":"Molto","D-4-D":"Molto","D-4-E":"Per niente","D-5-A":"Abbastanza","D-5-B":"Abbastanza","D-5-C":"Abbastanza","D-5-D":"Abbastanza","D-5-E":"Per niente","D-6-A":"Molto","D-6-B":"Molto","D-6-C":"Poco","D-6-D":"Per niente","D-6-E":"Abbastanza","D-7-A":"Molto","D-7-B":"Molto","D-7-C":"Molto","D-7-D":"Poco","D-8-A":"Abbastanza","D-8-B":"Abbastanza","D-8-C":"Abbastanza","D-8-D":"Abbastanza","D-9-A":"Molto","D-9-B":"Molto","D-9-C":"Poco","D-9-D":"Molto","D-10-A":"Molto","D-10-B":"Molto","D-10-C":"Molto","D-10-D":"Poco","D-10-E":"Molto","D-11-E":"Molto","E-1-A":"Molto","E-1-B":"Molto","E-1-C":"Molto","E-1-D":"Per niente","E-1-E":"Abbastanza","E-2-A":"Molto","E-2-B":"Molto","E-2-C":"Molto","E-2-D":"Molto","E-2-E":"Molto","E-3-A":"Molto","E-3-B":"Per niente","E-3-C":"Abbastanza","E-3-D":"Abbastanza","F-1-A":"Il problem solving","F-1-B":"L\'albero dei saperi informali","F-1-C":"l\'autostima","F-1-D":"Le competenze di base","F-1-E":"la resilienza","F-3-A":"nessuna","F-4-A":"le schede di approfondimento teorico con qualche immagine o schema in pi\u00f9.","F-4-B":"Aggiungere qualche ramo e foglie in più all\'albero dei saperi informali","F-4-C":"Aggiungere qualche esercizio di problem solving in più (per la scuola secondaria di secondo grado)","F-5":"Sì"}',
		'{"A-1":["Docente di scuola superiore"],"A-2-Profilo_personale-A":"Utilizzata in una sola classe","A-2-Profilo_personale-B":"Utilizzata in una sola classe","A-2-Profilo_personale-C":"Utilizzata in una sola classe","A-2-Profilo_personale-D":"Utilizzata in una sola classe","A-2-Profilo_personale-E":"Utilizzata in una sola classe","A-2-Profilo_personale-F":"Utilizzata in una sola classe","A-2-Profilo_personale-G":"Utilizzata in una sola classe","A-2-Profilo_personale-H":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Profilo_personale-J":"Utilizzata in una sola classe","A-2-Competenze_di_base-A":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Competenze_di_base-C":"Utilizzata in una sola classe","A-2-Competenze_di_base-D":"Utilizzata in una sola classe","A-2-Competenze_di_base-E":"Utilizzata in una sola classe","A-2-Competenze_di_base-F":"Utilizzata in una sola classe","A-2-Competenze_di_base-G":"Utilizzata in una sola classe","A-2-Saperi_informali-A":"Utilizzata in una sola classe","A-2-Saperi_informali-B":"Utilizzata in una sola classe","A-2-Scegliere-A":"Utilizzata in una sola classe","A-2-Scegliere-B":"Utilizzata in una sola classe","B-1":"La maggior parte della classe","B-2":"Generalmente abbastanza","C-1":"Ha suscitato qualche interesse ma nessun coinvolgimento","C-2":"Non ha influito in alcun modo sulla didattica disciplinare","C-3":"Non ha avuto nessun raccordo con l\'alternanza scuola-lavoro","D-1-A":"Abbastanza","D-1-B":"Abbastanza","D-1-C":"Abbastanza","D-1-D":"Abbastanza","D-1-E":"Abbastanza","D-2-A":"Abbastanza","D-2-B":"Abbastanza","D-2-C":"Abbastanza","D-2-D":"Abbastanza","D-2-E":"Abbastanza","D-2-F":"Poco","D-2-G":"Abbastanza","D-3-A":"Abbastanza","D-3-B":"Abbastanza","D-3-C":"Abbastanza","D-3-D":"Abbastanza","D-3-F":"Abbastanza","D-4-A":"Abbastanza","D-4-B":"Abbastanza","D-4-C":"Abbastanza","D-4-F":"Abbastanza","D-5-A":"Abbastanza","D-5-B":"Abbastanza","D-5-C":"Abbastanza","D-5-F":"Abbastanza","D-6-A":"Abbastanza","D-6-B":"Abbastanza","D-7-A":"Abbastanza","D-7-B":"Abbastanza","D-8-A":"Abbastanza","D-8-B":"Abbastanza","D-8-C":"Abbastanza","D-9-A":"Abbastanza","D-9-B":"Abbastanza","D-10-A":"Abbastanza","D-10-B":"Abbastanza","D-10-C":"Abbastanza","D-11-A":"Abbastanza","D-11-B":"Abbastanza","D-11-C":"Abbastanza","E-1-A":"Abbastanza","E-1-B":"Abbastanza","E-1-E":"Abbastanza","E-2-A":"Abbastanza","E-2-B":"Abbastanza","E-2-C":"Abbastanza","E-2-D":"Abbastanza","E-2-E":"Abbastanza","E-3-A":"Abbastanza","E-3-B":"Abbastanza","E-3-C":"Abbastanza","E-3-D":"Abbastanza","F-1-A":"Profilo personale","F-1-B":"Competenza di base","F-5":"Sì"}',
		'{"A-2-Profilo_personale-C":"Utilizzata in una sola classe","A-2-Profilo_personale-F":"Utilizzata in una sola classe","A-2-Profilo_personale-G":"Utilizzata in una sola classe","A-2-Profilo_personale-I":"Utilizzata in una sola classe","A-2-Competenze_di_base-B":"Utilizzata in una sola classe","A-2-Competenze_di_base-G":"Utilizzata in una sola classe","B-1":"Tutta la classe","B-2":"Generalmente molto","C-1":"Ha suscitato qualche interesse ma nessun coinvolgimento","C-2":"Non ha influito in alcun modo sulla didattica disciplinare","C-3":"Non ha avuto nessun raccordo con l\'alternanza scuola-lavoro","D-1-A":"Molto","D-1-B":"Molto","D-1-C":"Molto","D-1-D":"Molto","D-1-E":"Molto","D-2-A":"Molto","D-2-G":"Molto","D-3-A":"Molto","D-3-B":"Molto","D-3-C":"Abbastanza","D-3-D":"Molto","D-3-E":"Poco","D-4-A":"Molto","D-4-C":"Molto","D-4-F":"Molto","D-5-F":"Molto","D-7-A":"Molto","D-7-B":"Molto","D-7-C":"Poco","D-7-D":"Per niente","D-8-A":"Molto","D-8-B":"Molto","D-8-C":"Molto","D-8-D":"Molto","D-9-A":"Molto","D-9-B":"Molto","D-9-C":"Molto","D-9-D":"Molto","D-10-A":"Molto","D-10-B":"Molto","D-10-C":"Molto","D-10-D":"Molto","D-10-E":"Molto","D-11-E":"Molto","E-1-A":"Molto","E-1-B":"Molto","E-1-C":"Per niente","E-1-D":"Per niente","E-1-E":"Molto","E-2-A":"Molto","E-2-B":"Molto","E-2-C":"Molto","E-2-E":"Molto","E-3-A":"Molto","E-3-B":"Per niente","E-3-C":"Molto","E-3-D":"Molto","F-5":"Sì"}',
	];

	$answers = [
		"A-1",
		"A-2-Profilo_personale-A", "A-2-Profilo_personale-B", "A-2-Profilo_personale-C", "A-2-Profilo_personale-D", "A-2-Profilo_personale-E", "A-2-Profilo_personale-F", "A-2-Profilo_personale-G", "A-2-Profilo_personale-H", "A-2-Profilo_personale-I", "A-2-Profilo_personale-J", "A-2-Competenze_di_Base-A", "A-2-Competenze_di_Base-B", "A-2-Competenze_di_Base-C", "A-2-Competenze_di_Base-D", "A-2-Competenze_di_Base-E", "A-2-Competenze_di_Base-F", "A-2-Competenze_di_Base-G", "A-2-Saperi_informali-A", "A-2-Saperi_informali-B", "A-2-Scegliere-A", "A-2-Scegliere-B",
		"B-1", "B-2",
		"C-1", "C-2", "C-3",
		"D-1-A", "D-1-B", "D-1-C", "D-1-D", "D-1-E",
		"D-2-A", "D-2-B", "D-2-C", "D-2-D", "D-2-E", "D-2-F", "D-2-G",
		"D-3-A", "D-3-B", "D-3-C", "D-3-D", "D-3-E", "D-3-F",
		"D-4-A", "D-4-B", "D-4-C", "D-4-D", "D-4-E", "D-4-F",
		"D-5-A", "D-5-B", "D-5-C", "D-5-D", "D-5-E", "D-5-F",
		"D-6-A", "D-6-B", "D-6-C", "D-6-D", "D-6-E",
		"D-7-A", "D-7-B", "D-7-C", "D-7-D", "D-7-E",
		"D-8-A", "D-8-B", "D-8-C", "D-8-D", "D-8-E",
		"D-9-A", "D-9-B", "D-9-C", "D-9-D", "D-9-E",
		"D-10-A", "D-10-B", "D-10-C", "D-10-D", "D-10-E", "D-10-F",
		"D-11-A", "D-11-B", "D-11-C", "D-11-D", "D-11-E",
		"E-1-A", "E-1-B", "E-1-C", "E-1-D", "E-1-E",
		"E-2-A", "E-2-B", "E-2-C", "E-2-D", "E-2-E",
		"E-3-A", "E-3-B", "E-3-C", "E-3-D",
		"F-1-A", "F-1-B", "F-1-C", "F-1-D", "F-1-E",
		"F-2-A", "F-2-B", "F-2-C", "F-2-D", "F-2-E",
		"F-3-A", "F-3-B", "F-3-C", "F-3-D", "F-3-E",
		"F-4-A", "F-4-B", "F-4-C", "F-4-D", "F-4-E",
		"F-5"
	];

	echo implode(';', $answers) . '<br>';

	foreach ($results as $resultId => $result) {
		$resultsJson = json_decode($result, true);
		$formattedAnswer = [];

		foreach ($answers as $answer) {
			$formattedAnswer[$answer] = $resultsJson[$answer] ?? '.';
			if (is_array($formattedAnswer[$answer])) {
				$formattedAnswer[$answer] = implode(' - ', $formattedAnswer[$answer]);
			}
		}

		echo implode(';', $formattedAnswer) . '<br>';
	}
})->name('results');
