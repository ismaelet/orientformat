<?php

// theme
$this->styles->add(SERVER_ROOT . '/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT . '/pages/scripts/teacher/teacher.js');

// fetch class
$grade = \Legacy\System\Classes\LegacyDB::find('class FROM users WHERE id = ?', [$user->id]);

// fetch students
$students = \Legacy\System\Classes\LegacyDB::select('* FROM users WHERE class = ? AND level=0 ORDER BY lastname ASC, firstname ASC, id ASC', [$grade]);

// activate a student
if (isset($_POST['activate'])) {

	$id = $_POST['id'];

	\Legacy\System\Classes\LegacyDB::update('users SET status=1 WHERE id = ?', $id);

	redirect_old();
}

if (isset($_POST['deactivate'])) {

	$id = $_POST['id'];

	\Legacy\System\Classes\LegacyDB::update('users SET status=0 WHERE id = ?', $id);

	redirect_old();
}

// reset password
if (isset($_POST['reset'])) {

	$id = $_POST['id'];

	$_SESSION['password_reset'] = true;

	redirect_old('/teacher/students/reset?id=' . $id);
}
