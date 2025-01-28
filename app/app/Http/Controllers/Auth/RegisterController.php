<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Legacy\SchoolSystem\SchoolClass;
use Legacy\UserSystem\Student;

class RegisterController extends Controller {
	public function index() {
		return view('auth.register')
			->with('locationTag', 'login')
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
		]);

		// parameters
		$loginType = $request->type;
		$firstname = trim($request->firstname);
		$lastname = trim($request->lastname);
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
		$usernameFirstName = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $firstname)), 0, 8));
		$usernameLastName = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $lastname)), 0, 8));
		$userNameRandomNumber = rand(1000, 9999);

		$username = $usernameFirstName . '.' . $usernameLastName . $userNameRandomNumber;

		while (\App\Legacy\LegacyDB::exists('users WHERE username = ?', [$username])) {
			$userNameRandomNumber = rand(1000, 9999);
			$username = $usernameFirstName . '.' . $usernameLastName . $userNameRandomNumber;
		}

		// try to register the user
		switch (true) {
			case strlen($password) < 8:
				// password too short
				$error = 'password-short';
				break;

			case $password != $passwordConfirmation:
				// password and password confirmation don't match
				$error = 'password-match';
				break;

			case \App\Legacy\LegacyDB::exists('users WHERE email = ?', [$email]):
				// email already used
				$error = 'duplicate-email';
				break;

			case $loginType == $studentType && !$schoolClassId:
				// no school class found matching the student class code
				$error = 'class-wrong';
				break;

			case $loginType == $studentType && \App\Legacy\LegacyDB::exists('users WHERE firstName = ? AND lastName = ? AND id IN (SELECT ' . Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?)', [$firstname, $lastname, $schoolClassId]):
				// already exists a student in the selected school class with the same firstname and lastname
				$error = 'duplicate-name';
				break;

			case $loginType == $teacherType && !in_array($emailDomain, AVAILABLE_EMAIL_DOMAINS):
				// the teacher's email is not in the allowed list
				$error = 'invalid-email';
				break;

			default:
				// generate the user
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

				if ($loginType == $studentType) {
					// generate the student
					$userId = \App\Legacy\LegacyDB::add('users (username, password, firstName, lastName, email, birthdate)', [$username, $hashedPassword, $firstname, $lastname, $email, $birthdate]);

					\App\Legacy\LegacyDB::add('students (userId, id, ' . Student::SCHOOL_CLASS_INDEX . ')', [$userId, $userId, $schoolClassId]);
				} else {
					// generate the teacher
					$userId = \App\Legacy\LegacyDB::add('users (username, password, firstName, lastName, email, groupId)', [$username, $hashedPassword, $firstname, $lastname, $email, 1]);

					\App\Legacy\LegacyDB::add('teachers (userId)', [$userId]);
				}

				// Sign in the user
				auth()->attempt($request->only('email', 'password'));

				// Redirect
				return redirect()->route('home');
		}

		return redirect()->route('login', [
			'error' => $error,
			'login-type' => $loginType,
			'register' => true,
		]);
	}
}
