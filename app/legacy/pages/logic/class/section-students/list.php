<?php

use Illuminate\Support\Facades\DB;
use Legacy\UserSystem\Student;

$studentCount = schoolClass()->studentCount;

// activate a student
if (isset($_POST['activate'])) {
    DB::update('UPDATE '.('users SET status = 1 WHERE id = ?'), (array) ([$_POST['activate']]));
    DB::update('UPDATE '.('students SET status = 1 WHERE '.Student::INDEX.' = ?'), (array) ([$_POST['activate']]));

    redirect_old();
}

if (isset($_POST['deactivate'])) {
    DB::update('UPDATE '.('users SET status = 0 WHERE id = ?'), (array) ([$_POST['deactivate']]));
    DB::update('UPDATE '.('students SET status = 0 WHERE '.Student::INDEX.' = ?'), (array) ([$_POST['deactivate']]));

    redirect_old();
}

// reset password
if (isset($_POST['reset'])) {
    $_SESSION['student-password-reset'] = true;

    redirect_old('/class/students/password-reset?id='.$_POST['reset']);
}
