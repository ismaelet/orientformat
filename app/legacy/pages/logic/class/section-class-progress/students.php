<?php

use App\Legacy\LegacyDB;

// get user
global $user, $grade;

// fetch students
$students = LegacyDB::select('* FROM users WHERE id IN (SELECT userId FROM students WHERE classId = ? AND status=1) ORDER BY last_name ASC, first_name ASC, id ASC', [$grade->id]);

// activate a student
if (isset($_POST['activate'])) {
    $id = $_POST['id'];

    LegacyDB::update('users SET status=1 WHERE id = ?', $id);

    redirect_old();
}

if (isset($_POST['deactivate'])) {
    $id = $_POST['id'];

    LegacyDB::update('users SET status=0 WHERE id = ?', $id);

    redirect_old();
}

// reset password
if (isset($_POST['reset'])) {
    $id = $_POST['id'];

    $_SESSION['password_reset'] = true;

    redirect_old('/class/students/reset?id='.$id);
}
