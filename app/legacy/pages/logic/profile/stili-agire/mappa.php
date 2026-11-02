<?php

use App\Legacy\StyleLoader;

StyleLoader::add('profile/stili/'.legacy_test()->slug, 'page');

$title = 'Modi di agire';

$resultOrder = ['Riflessivo', 'Livellatore', 'Impulsivo', 'Correttore', 'Pragmatico', 'Acutizzatore', 'Metodico', 'Pianificatore'];

include_once __DIR__.'/../stili/'.legacy_test()->slug.'.php';
