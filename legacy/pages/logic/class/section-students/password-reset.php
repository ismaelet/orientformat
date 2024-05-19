<?php

// setup variables
$valid = false;
$studentId = $_GET['id'] ?? null;
$student = new \Legacy\UserSystem\Student($studentId);

if ($student->schoolClassId == schoolClassId() && isset($_SESSION['student-password-reset'])) {
	unset($_SESSION['student-password-reset']);

	$valid = true;
}

if (!$valid) {
	redirect_old('/class/students/list');
}

// generate new password
$password = bin2hex(random_bytes(5));

\App\Legacy\LegacyDB::update('users SET password = ? WHERE id = ?', [$password, $studentId]);
