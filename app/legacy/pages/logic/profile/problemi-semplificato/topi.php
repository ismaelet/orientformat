<?php

use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;

StyleLoader::add('profile/problemi-semplificato/quadrati', 'page');
ScriptLoader::add('profile/problemi-semplificato/quadrati', 'page');

$correctAnswer = 7;

include_once 'quadrati.php';
