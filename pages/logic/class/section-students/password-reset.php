<?php

// setup variables
$valid = false;
$studentId = $_GET['id'] ?? null;
$student = new UserSystem\Student($studentId);

if ($student->schoolClassId == schoolClassId() && isset($_SESSION['student-password-reset'])) {
	unset($_SESSION['student-password-reset']);

	$valid = true;
}

if (!$valid) {
	redirect('/class/students/list');
}

// generate new password
$password = bin2hex(random_bytes(5));

DB::update('users SET password = ? WHERE id = ?', [$password, $studentId]);
