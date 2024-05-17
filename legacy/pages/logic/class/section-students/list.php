<?php

use \Legacy\UserSystem\Student;

$studentCount = schoolClass()->studentCount;

// activate a student
if (isset($_POST['activate'])) {
	\System\Classes\DBOld::update(User::TABLE . ' SET status = 1 WHERE ' . User::INDEX . ' = ?', [$_POST['activate']]);
	\System\Classes\DBOld::update(Student::TABLE . ' SET status = 1 WHERE ' . Student::INDEX . ' = ?', [$_POST['activate']]);

	redirect_old();
}

if (isset($_POST['deactivate'])) {
	\System\Classes\DBOld::update(User::TABLE . ' SET status = 0 WHERE ' . User::INDEX . ' = ?', [$_POST['deactivate']]);
	\System\Classes\DBOld::update(Student::TABLE . ' SET status = 0 WHERE ' . Student::INDEX . ' = ?', [$_POST['deactivate']]);

	redirect_old();
}

// reset password
if (isset($_POST['reset'])) {
	$_SESSION['student-password-reset'] = true;

	redirect_old('/class/students/password-reset?id=' . $_POST['reset']);
}
