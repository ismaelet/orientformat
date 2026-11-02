<?php

use Illuminate\Support\Facades\DB;

$error = false;

$title = 'Aggiungi il tuo<br>indirizzo e-mail';

$inputs = [
    [
        ['type' => 'lbl', 'text' => 'Indirizzo e-mail'],
        ['type' => 'email', 'text' => 'Indirizzo e-mail', 'name' => 'email', 'required' => true],
        ['type' => 'email', 'text' => 'Conferma l\'indirizzo e-mail', 'name' => 'confirmation-email', 'required' => true],
        ['type' => 'error', 'text' => 'Gli indirizzi inseriti non coincidono', 'error' => 'not-matching-email'],
        ['type' => 'error', 'text' => 'Questo indirizzo email è già associato ad un altro account', 'error' => 'existent-email'],
    ],
];

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $confirmationEmail = $_POST['confirmation-email'];

    if ($email != $confirmationEmail) {
        $error = 'not-matching-email';
    } elseif (DB::selectOne('SELECT 1 FROM '.('users WHERE email = ?').' LIMIT 1', (array) ([$email])) !== null) {
        $error = 'existent-email';
    } else {
        DB::update('UPDATE '.('users SET email = ? WHERE id = ?'), (array) ([$email, user()->id]));
    }

    redirect_old('/');
}
