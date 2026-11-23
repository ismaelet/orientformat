@extends('emails.default-email')

@section('email-content')
    <h2>Reimposta la tua password</h2>
    <p>Ciao,</p>
    <p>abbiamo ricevuto una richiesta per reimpostare la password del tuo account. Clicca sul pulsante qui sotto per scegliere una nuova password.</p>
    <p style="margin: 24px 0; text-align: center;">
        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 12px 24px; border-radius: 8px; background-color: hsl(216, 86%, 20%); color: #fff; font-weight: 600; text-decoration: none;">Reimposta password</a>
    </p>
    <p>Il link scade tra {{ $expiresInMinutes }} minuti.</p>
    <p>Se non hai richiesto di reimpostare la password, puoi ignorare questa email: la tua password rimarrà invariata.</p>
    <p style="margin-top: 24px;">Se il pulsante non funziona, copia e incolla questo indirizzo nel browser:</p>
    <p style="overflow-wrap: anywhere; word-break: break-all;"><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
@endsection
