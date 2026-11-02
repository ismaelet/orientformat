<?php

// 'desc' => 'Stai per iniziare un percorso di autoscoperta, di responsabilizzazione nelle scelte da compiere e di confronto.',

// theme

use Illuminate\Support\Facades\Auth;

$header['floating'] = true;

$student = Auth::user()->student;
