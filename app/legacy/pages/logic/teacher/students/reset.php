<?php

use Illuminate\Support\Facades\DB;

// setup variables
$id = $_GET['id'] ?? false;
$valid = false;

if (isset($_SESSION['password_reset'])) {

    unset($_SESSION['password_reset']);
    $valid = true;
}

if (! $valid || DB::selectOne('SELECT 1 FROM '.('users WHERE id = ? AND level=0').' LIMIT 1', (array) ([$id])) === null) {
    redirect_old('/teacher/students');
}

// generate new password
$password = bin2hex(random_bytes(5));

$db_password = password_hash($password, PASSWORD_DEFAULT);

DB::update('UPDATE '.('users SET password = ? WHERE id = ?'), (array) ([$db_password, $id]));

// store variables
$this->set('password', $password);
