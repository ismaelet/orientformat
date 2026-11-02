<?php

use Illuminate\Support\Facades\DB;

// get user
global $user, $grade;

// fetch students
$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM users WHERE id IN (SELECT userId FROM students WHERE classId = ? AND status=1) ORDER BY last_name ASC, first_name ASC, id ASC'), (array) ([$grade->id])));

// activate a student
if (isset($_POST['activate'])) {
    $id = $_POST['id'];

    DB::update('UPDATE '.('users SET status=1 WHERE id = ?'), (array) ($id));

    redirect_old();
}

if (isset($_POST['deactivate'])) {
    $id = $_POST['id'];

    DB::update('UPDATE '.('users SET status=0 WHERE id = ?'), (array) ($id));

    redirect_old();
}

// reset password
if (isset($_POST['reset'])) {
    $id = $_POST['id'];

    $_SESSION['password_reset'] = true;

    redirect_old('/class/students/reset?id='.$id);
}
