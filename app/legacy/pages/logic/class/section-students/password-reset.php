<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Legacy\UserSystem\Student;

$valid = false;
$studentId = $_GET['id'] ?? null;
$user = User::find($studentId);
$student = new Student($studentId);

if ($student->schoolClassId == schoolClassId() && isset($_SESSION['student-password-reset'])) {
    unset($_SESSION['student-password-reset']);

    $valid = true;
}

if (! $valid) {
    redirect_old('/class/students/list');
}

// generate new password
$password = bin2hex(random_bytes(5));

$user->update([
    'password' => Hash::make($password),
]);
