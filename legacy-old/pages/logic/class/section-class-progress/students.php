<?php

// get user
global $user, $grade;

// fetch students
$students = DB::select('* FROM users WHERE id IN (SELECT userId FROM students WHERE classId = ? AND status=1) ORDER BY lastname ASC, firstname ASC, id ASC', [$grade->id]);

// activate a student
if (isset($_POST['activate'])) {
	$id = $_POST['id'];

	DB::update('users SET status=1 WHERE id = ?', $id);

	redirect();
}

if (isset($_POST['deactivate'])) {
	$id = $_POST['id'];

	DB::update('users SET status=0 WHERE id = ?', $id);

	redirect();
}

// reset password
if (isset($_POST['reset'])) {
	$id = $_POST['id'];

	$_SESSION['password_reset'] = true;

	redirect('/class/students/reset?id=' . $id);
}
