<?php

use Illuminate\Support\Facades\DB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// fetch class
$grade = DB::scalar('SELECT '.('class FROM users WHERE id = ?').' LIMIT 1', (array) ([$user->id])) ?? false;

// fetch students
$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM users WHERE class = ? AND level=0 ORDER BY last_name ASC, first_name ASC, id ASC'), (array) ([$grade])));

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

    redirect_old('/teacher/students/reset?id='.$id);
}
