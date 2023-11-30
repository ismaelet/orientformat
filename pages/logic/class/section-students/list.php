<?php

use UserSystem\Student;

$studentCount = schoolClass()->studentCount;

// activate a student
if (isset($_POST['activate'])) {
	DB::update(User::TABLE . ' SET status = 1 WHERE ' . User::INDEX . ' = ?', [$_POST['activate']]);
	DB::update(Student::TABLE . ' SET status = 1 WHERE ' . Student::INDEX . ' = ?', [$_POST['activate']]);

	redirect();
}

if (isset($_POST['deactivate'])) {
	DB::update(User::TABLE . ' SET status = 0 WHERE ' . User::INDEX . ' = ?', [$_POST['deactivate']]);
	DB::update(Student::TABLE . ' SET status = 0 WHERE ' . Student::INDEX . ' = ?', [$_POST['deactivate']]);

	redirect();
}

// reset password
if (isset($_POST['reset'])) {
	$_SESSION['student-password-reset'] = true;

	redirect('/class/students/password-reset?id=' . $_POST['reset']);
}
