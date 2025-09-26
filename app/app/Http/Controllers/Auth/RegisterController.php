<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {

	/**
	 * The available email domains for teacher registration
	 */
	public const array AVAILABLE_EMAIL_DOMAINS = [
		'arcivescoviletrento.it',
		'artigianelli.tn.it',
		'buonarroti.tn.it',
		'centromoda.tn.it',
		'cfp-upt.it',
		'cfpgveronesi.it',
		'enaip.tn.it',
		'fmach.it',
		'gardascuola.it',
		'iasma.it',
		'iprase.tn.it',
		'istitutodecarneri.it',
		'istitutosacrocuore.it',
		'liceodellearti.tn.it',
		'mileschool.it',
		'operaarmidabarelli.org',
		'pavoniani.tn.it',
		'provincia.tn.it',
		'sacrafamigliatrento.it',
		'scuolasteiner-trento.it',
		'scuolaveronesi.it',
		'scuole.provincia.tn.it',
		'sdbmezzano.it',
		'sdbtrento.it',
		'icfondorevo.it',
	];

	/**
	 * Handle an incoming registration request
	 */
	public function store(Request $request): RedirectResponse {
		$loginType = $request->type;

		if ($loginType == 'student') {
			return $this->storeStudent($request);
		} else if ($loginType == 'teacher') {
			return $this->storeTeacher($request);
		}

		return redirect()->back()->withErrors(['type' => 'Si è verificato un errore. Riprova più tardi o contattaci tramite il supporto.'])->withInput();
	}

	/**
	 * Store a newly created student in storage
	 */
	private function storeStudent(Request $request): RedirectResponse {
		$request->validate([
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'password' => 'required|string|min:8|max:30|confirmed',
			'email' => 'required|string|email|max:255',
			'birthdate' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d') . '|after:' . now()->subYears(100)->format('Y-m-d'),
			'class' => 'required|string|exists:school_classes,code',
		]);

		$class = SchoolClass::where('code', $request->class)->first();

		if (Student::where('schoolClassId', $class->id)
			->whereHas('user', function ($query) use ($request) {
				$query->where('first_name', $request->first_name)
					->where('last_name', $request->last_name);
			})->exists()
		) {
			return redirect()
				->back()
				->withErrors(['name' => 'Esiste già un account con questo nome e cognome registrato a questa classe.'])
				->withInput();
		}

		$hashedPassword = Hash::make($request->password);

		// Create the user
		$user = User::create([
			'password' => $hashedPassword,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'birthdate' => $request->birthdate,
		]);

		// Create the student
		Student::create([
			'id' => $user->id,
			'userId' => $user->id,
			'schoolClassId' => $class->id,
		]);

		// Sign in the user
		Auth::attempt($request->only('email', 'password'));

		// Redirect
		return redirect()->route('home');
	}

	/**
	 * Store a newly created teacher in storage
	 */
	private function storeTeacher(Request $request): RedirectResponse {
		$request->validate([
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'password' => 'required|string|min:8|max:30|confirmed',
			'email' => 'required|string|email|max:255',
		]);

		$emailDomain = explode('@', $request->email)[1] ?? '';
		$emailDomain = strtolower($emailDomain);

		if (!$emailDomain || !in_array($emailDomain, self::AVAILABLE_EMAIL_DOMAINS)) {
			return redirect()
				->back()
				->withErrors(['email' => 'Indirizzo email non supportato. Per vedere la lista dei domini email supportati dalla piattaforma clicca <a class="font-bold" href="' . route('help', ['category' => 1, 'topic' => 11]) . '#topic11">qui</a>'])
				->withInput();
		}

		$hashedPassword = Hash::make($request->password);

		// Create the user
		$user = User::create([
			'password' => $hashedPassword,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
		]);

		// Create the teacher
		Teacher::create([
			'id' => $user->id,
			'user_id' => $user->id,
		]);

		// Sign in the user
		Auth::attempt($request->only('email', 'password'));

		// Redirect
		return redirect()->route('home');
	}
}
