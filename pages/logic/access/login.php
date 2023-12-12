<?php

use SchoolSystem\SchoolClass;
use UserSystem\Student;

define('AVAILABLE_EMAIL_DOMAINS', [
	'arcivescoviletrento.it',
	'artigianelli.tn.it',
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

$header['floating'] = true;

// setup variabiles
$error = false;
$studentType = 'student';
$teacherType = 'teacher';
$loginType = $_GET['login-type'] ?? null;
$loginType = in_array($loginType, [$studentType, $teacherType]) ? $loginType : $studentType;

/**
 * Login
 */
if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$remember = false;
	$url = $_POST['url'] ?? null;

	if ($username && DB::exists('users WHERE (username = ? OR email = ?) AND ' . User::GROUP_INDEX . ' IN (0, 1)', [$username, $username])) {
		$error = standard_login($username, $password, $url, $remember);
	} else {
		$error = 'wrong-data';
	}
}

/**
 * Registration
 */
if (isset($_POST['register'])) {
	// parameters
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$password = $_POST['password'];
	$passwordConfirmation = $_POST['cpassword'];
	$email = $_POST['email'];
	$emailDomain = explode('@', $_POST['email'])[1] ?? '';
	$emailDomain = strtolower($emailDomain);

	// student specifc parameters
	$birthdate = $loginType == $studentType ? $_POST['birthdate'] : null;
	$schoolClassCode = $loginType == $studentType ? $_POST['class'] : null;
	$schoolClassId = $loginType == $studentType ? DB::find('id FROM ' . SchoolClass::TABLE . ' WHERE code = ?', [$schoolClassCode]) : null;

	// generate the username
	$usernameFirstName = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $firstname)), 0, 8));
	$usernameLastName = strtolower(substr(preg_replace("/[^A-Za-z0-9 ]/", '', str_replace(' ', '', $lastname)), 0, 8));
	$userNameRandomNumber = rand(1000, 9999);

	$username = $usernameFirstName . '.' . $usernameLastName . $userNameRandomNumber;

	while (DB::exists('users WHERE username = ?', [$username])) {
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

		case DB::exists('users WHERE email = ?', [$email]):
			// email already used
			$error = 'duplicate-email';
			break;

		case $loginType == $studentType && !$schoolClassId:
			// no school class found matching the student class code
			$error = 'class-wrong';
			break;

		case $loginType == $studentType && DB::exists('users WHERE firstName = ? AND lastName = ? AND id IN (SELECT ' . Student::INDEX . ' FROM ' . Student::TABLE . ' WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ?)', [$firstname, $lastname, $schoolClassId]):
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
				$userId = DB::add('users (username, password, firstName, lastName, email, birthdate)', [$username, $hashedPassword, $firstname, $lastname, $email, $birthdate]);

				DB::add('students (userId, id, ' . Student::SCHOOL_CLASS_INDEX . ')', [$userId, $userId, $schoolClassId]);
			} else {
				// generate the teacher
				$userId = DB::add('users (username, password, firstName, lastName, email, ' . User::GROUP_INDEX . ')', [$username, $hashedPassword, $firstname, $lastname, $email, 1]);

				DB::add('teachers (userId)', [$userId]);
			}

			// log the user in
			standard_login($username, $password, '/register/success');
	}
}
