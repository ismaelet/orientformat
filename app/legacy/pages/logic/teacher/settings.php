<?php

use Illuminate\Support\Facades\DB;

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

    if (DB::selectOne('SELECT 1 FROM '.('users WHERE email = ? AND id <> ?').' LIMIT 1', (array) ([$mail, userId()])) !== null) {
        $error = 'existing-mail';
    } elseif (DB::selectOne('SELECT 1 FROM '.('users WHERE username = ? AND id <> ?').' LIMIT 1', (array) ([$_POST['username'], userId()])) !== null) {
        $error = 'existing-username';
    } else {
        form_db_update('users', $dataInputs, 'id', userId());
        redirect_old('?done=1#user-data');
    }

    redirect_old('?error='.$error.'#user-data');
}

if (isset($_POST['edit-password'])) {
    $dbPassword = DB::scalar('SELECT '.('password FROM users WHERE id = ?').' LIMIT 1', (array) ([userId()])) ?? false;
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
        DB::update('UPDATE '.('users SET password = ? WHERE id = ?'), (array) ([$newPassword, userId()]));
        redirect_old('?done=1#user-data');
    }

    redirect_old('?error='.$error.'#password-edit');
}
