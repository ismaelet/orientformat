<?php

$solution = ['H', 'C', 'E'];
$answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

\Legacy\System\Classes\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
\Legacy\System\Classes\ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
