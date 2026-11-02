<?php

use App\Legacy\LegacyDB;

$error = $_GET['error'] ?? false;
$done = $_GET['done'] ?? false;

$dataInputs = [
    [
        ['type' => 'lbl', 'text' => 'Nome completo'],
        ['text' => 'Nome', 'name' => 'first_name', 'size' => 2, 'value' => user()->first_name ?: '', 'minlength' => 2, 'required' => true],
        ['text' => 'Cognome', 'name' => 'last_name', 'size' => 2, 'value' => user()->last_name ?: '', 'minlength' => 2, 'required' => true],
    ],
    [
        ['type' => 'lbl', 'text' => 'Indirizzo email'],
        ['type' => 'email', 'text' => 'Indirizzo email', 'name' => 'email', 'value' => user()->email ?: '', 'required' => true],
        ['type' => 'error', 'error' => 'existing-mail', 'text' => 'L\'indirizzo email scelto è già in uso'],
    ],
];

$passwordInputs = [
    [
        ['type' => 'lbl', 'text' => 'Password vecchia'],
        ['type' => 'password', 'text' => 'Password vecchia', 'name' => 'old-password', 'size' => 2],
        ['type' => 'error', 'error' => 'wrong-password', 'text' => 'Password vecchia sbagliata'],
    ],
    [
        ['type' => 'lbl', 'text' => 'Password nuova'],
        ['type' => 'password', 'text' => 'Password nuova', 'name' => 'new-password', 'size' => 2, 'minlength' => 6],
        ['type' => 'password', 'text' => 'Confermare la password', 'name' => 'password-confirmation', 'size' => 2, 'minlength' => 6],
        ['type' => 'error', 'error' => 'password-length', 'text' => 'La password scelta deve avere almeno 6 caratteri'],
        ['type' => 'error', 'error' => 'password-not-matching', 'text' => 'Le password inserite non corrispondono'],
    ],
];

/*
* Form
*/
if (isset($_POST['edit-data'])) {
    $mail = $_POST['email'];

    if (LegacyDB::exists('users WHERE email = ? AND id <> ?', [$mail, userId()])) {
        $error = 'existing-mail';
    } elseif (LegacyDB::exists('users WHERE username = ? AND id <> ?', [$_POST['username'], userId()])) {
        $error = 'existing-username';
    } else {
        form_db_update('users', $dataInputs, 'id', userId());
        redirect_old('?done=1#user-data');
    }

    redirect_old('?error='.$error.'#user-data');
}

if (isset($_POST['edit-password'])) {
    $dbPassword = LegacyDB::find('password FROM users WHERE id = ?', [userId()]);
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];
    $passwordConfirmation = $_POST['password-confirmation'];

    if (! password_verify($oldPassword, $dbPassword)) {
        $error = 'wrong-password';
    } elseif (strlen($newPassword) < 6) {
        $error = 'password-length';
    } elseif ($newPassword != $passwordConfirmation) {
        $error = 'password-not-matching';
    } else {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        LegacyDB::update('users SET password = ? WHERE id = ?', [$newPassword, userId()]);
        redirect_old('?done=1#user-data');
    }

    redirect_old('?error='.$error.'#password-edit');
}
