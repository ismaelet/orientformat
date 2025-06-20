<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Schools\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller {

	/**
	 * Display the teacher dashboard
	 */
	public function index(): View {
		$teacher = teacher()->load('school', 'school_classes', 'school_classes.school');

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
			]
		];

		$notifications = Notification::latest()
			->limit(5)
			->get();

		return view('teacher.dashboard', [
			'title' => 'Dashboard Insegnante',
			'teacher' => $teacher,
			'functionalities' => $functionalities,
			'notifications' => $notifications,
		]);
	}

	/**
	 * Display the form to attach a school to a teacher
	 */
	public function showSchool(): View {
		$schools = School::orderBy('name')->get();

		return view('teacher.school', [
			'title' => 'Seleziona la tua scuola',
			'schools' => $schools,
		]);
	}

	/**
	 * Update the teacher's school
	 */
	public function storeSchool(Request $request): RedirectResponse {
		$request->validate([
			'school_id' => 'required|exists:schools,id',
		]);

		teacher()->update([
			'school_id' => $request->input('school_id'),
		]);

		return redirect()
			->route('home')
			->with('success', "La scelta dell'istituto è stata aggiornata con successo.");
	}
}
