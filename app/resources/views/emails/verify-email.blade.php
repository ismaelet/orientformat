@extends('emails.default-email')

@section('email-content')
    <h2>Conferma il tuo indirizzo email</h2>
    <p>Ciao,</p>
    <p>grazie per esserti registrato su {{ config('app.name') }}. Clicca sul pulsante qui sotto per confermare il tuo indirizzo email e accedere al tuo account.</p>
    <p style="margin: 24px 0; text-align: center;">
        <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 12px 24px; border-radius: 8px; background-color: hsl(216, 86%, 20%); color: #fff; font-weight: 600; text-decoration: none;">Conferma indirizzo email</a>
    </p>
    <p>Il link scade tra {{ $expiresInMinutes }} minuti.</p>
    <p>Se non hai creato un account, puoi ignorare questa email.</p>
    <p style="margin-top: 24px;">Se il pulsante non funziona, copia e incolla questo indirizzo nel browser:</p>
    <p style="overflow-wrap: anywhere; word-break: break-all;"><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
@endsection
