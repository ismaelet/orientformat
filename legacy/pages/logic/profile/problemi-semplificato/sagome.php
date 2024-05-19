<?php

$solution = ['H', 'C', 'E'];
$answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

\App\Legacy\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
\App\Legacy\ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
