<?php

$header['floating'] = true;

// setup variabiles
$error = $_GET['error'] ?? null;
$studentType = 'student';
$teacherType = 'teacher';
$loginType = $_GET['login-type'] ?? null;
$loginType = in_array($loginType, [$studentType, $teacherType]) ? $loginType : $studentType;
