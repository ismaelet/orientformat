<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Student as UserStudent;
use App\Models\User\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Legacy\SchoolSystem\SchoolClass;
use Legacy\UserSystem\Student;

class RegisterController extends Controller {
	public function index() {
		return view('auth.register')
			->with('location', 'login')
			->with('title', 'Registrati');
	}

	public function store(Request $request): RedirectResponse {
		define('AVAILABLE_EMAIL_DOMAINS', [
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
		]);

		// parameters
		$loginType = $request->type;
		$first_name = trim($request->first_name);
		$last_name = trim($request->last_name);
		$password = $request->password;
		$passwordConfirmation = $request->cpassword;
		$email = $request->email;
		$emailDomain = explode('@', $request->email)[1] ?? '';
		$emailDomain = strtolower($emailDomain);

		// student specifc parameters
		$studentType = 'student';
		$teacherType = 'teacher';
		$birthdate = $loginType == $studentType ? $request->birthdate : null;
		$schoolClassCode = $loginType == $studentType ? $request->class : null;
		$schoolClassId = $loginType == $studentType ? \App\Legacy\LegacyDB::find('id FROM ' . SchoolClass::TABLE . ' WHERE code = ?', [$schoolClassCode]) : null;

		// generate the username
		$usernamefirst_name = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $first_name)), 0, 8));
		$usernamelast_name = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $last_name)), 0, 8));
		$userNameRandomNumber = rand(1000, 9999);

		$username = $usernamefirst_name . '.' . $usernamelast_name . $userNameRandomNumber;

		while (\App\Legacy\LegacyDB::exists('users WHERE username = ?', [$username])) {
			$userNameRandomNumber = rand(1000, 9999);
			$username = $usernamefirst_name . '.' . $usernamelast_name . $userNameRandomNumber;
		}

		// try to register the user
		switch (true) {
			case strlen($password) < 8:
				// password too short
				return redirect()->back()->withErrors(['password' => 'La password deve avere almeno 8 caratteri'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			case $password != $passwordConfirmation:
				// password and password confirmation don't match
				return redirect()->back()->withErrors(['password' => 'Le password non coincidono'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			case \App\Legacy\LegacyDB::exists('users WHERE email = ?', [$email]):
				// email already used
				return redirect()->back()->withErrors(['email' => 'Esiste già un account associato a questo indirizzo email'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			case $loginType == $studentType && !$schoolClassId:
				// no school class found matching the student class code
				return redirect()->back()->withErrors(['class' => 'Codice della classe non riconosciuto'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			case $loginType == $studentType && \App\Legacy\LegacyDB::exists('users WHERE first_name = ? AND last_name = ? AND id IN (SELECT ' . Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?)', [$first_name, $last_name, $schoolClassId]):
				// already exists a student in the selected school class with the same first_name and last_name
				return redirect()->back()->withErrors(['name' => 'Esiste già un account con questo nome e cognome registrato a questa classe.'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			case $loginType == $teacherType && !in_array($emailDomain, AVAILABLE_EMAIL_DOMAINS):
				// the teacher's email is not in the allowed list
				return redirect()->back()->withErrors(['email' => 'Indirizzo email non supportato. Per vedere la lista dei domini email supportati dalla
							piattaforma clicca <a
								class="font-bold"
								href="' . client_url('/help?category=1&topic=11#topic11') . '"
							>qui</a>'])->withInput()->with(['register' => true, 'login-type' => $loginType,]);

			default:
				// generate the user
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

				if ($loginType == $studentType) {
					// generate the student
					$user = User::create([
						'username' => $username,
						'password' => $hashedPassword,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
						'birthdate' => $birthdate,
					]);

					UserStudent::create([
						'id' => $user->id,
						'userId' => $user->id,
						'schoolClassId' => $schoolClassId,
					]);
				} else {
					// generate the teacher
					$user = User::create([
						'username' => $username,
						'password' => $hashedPassword,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
					]);

					Teacher::create([
						'id' => $user->id,
						'user_id' => $user->id,
					]);
				}

				// Sign in the user
				Auth::attempt($request->only('email', 'password'));

				// Redirect
				return redirect()->route('home');
		}

		return redirect()->route('login', [
			'login-type' => $loginType,
			'register' => true,
		]);
	}
}
