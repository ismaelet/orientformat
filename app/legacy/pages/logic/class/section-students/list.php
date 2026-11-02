<?php

use App\Legacy\LegacyDB;
use Legacy\UserSystem\Student;

$studentCount = schoolClass()->studentCount;

// activate a student
if (isset($_POST['activate'])) {
    LegacyDB::update('users SET status = 1 WHERE id = ?', [$_POST['activate']]);
    LegacyDB::update('students SET status = 1 WHERE '.Student::INDEX.' = ?', [$_POST['activate']]);

    redirect_old();
}

if (isset($_POST['deactivate'])) {
    LegacyDB::update('users SET status = 0 WHERE id = ?', [$_POST['deactivate']]);
    LegacyDB::update('students SET status = 0 WHERE '.Student::INDEX.' = ?', [$_POST['deactivate']]);

    redirect_old();
}

// reset password
if (isset($_POST['reset'])) {
    $_SESSION['student-password-reset'] = true;

    redirect_old('/class/students/password-reset?id='.$_POST['reset']);
}
