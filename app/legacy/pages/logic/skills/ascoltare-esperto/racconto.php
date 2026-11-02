<?php

use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;

$questions = [
    'Qual era l’attività prevalente di Peter?',
    'Peter sognava di',
    'Chi era l’uomo dal cappotto di caimano?',
    'Quale di queste è una delle prove sostenute da Peter per ricevere la chitarra magica?',
    'Chi era Lucifumandro?',
    'Quale di questi punti caratterizza l’aspetto esteriore di Lucifumandro?',
    'Qual è il titolo del pezzo che suonava Peter quando si avvicinò il vecchio?',
    'Peter venne ucciso',
    'Per strada Peter non riusciva a racimolare soldi',
    'Qual è l’elemento a sorpresa che crea l’interesse e l’originalità del racconto?',
];

$answers = [
    [
        'right' => 2,
    ],
    [
        'right' => 1,
    ],
    [
        'right' => 3,
    ],
    [
        'right' => 4,
    ],
    [
        'right' => 2,
    ],
    [
        'right' => 3,
    ],
    [
        'right' => 3,
    ],
    [
        'right' => 2,
    ],
    [
        'right' => 3,
    ],
    [
        'right' => 4,
    ],
];

include_once __DIR__.'/../'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug.'.php';

StyleLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');
ScriptLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');
