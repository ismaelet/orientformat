<?php

use Illuminate\Support\Facades\DB;

$userId = $_GET['id'];
$error = false;
$done = false;

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password-confirmation'];

    if ($password != $passwordConfirmation) {
        $error = 'no-match';
    } else {
        DB::delete('DELETE FROM '.('user_resets WHERE userId = ?'), (array) ([$userId]));
        DB::update('UPDATE '.('users SET password = ? WHERE id = ?'), (array) ([$password, $userId]));

        $done = true;
    }
}
