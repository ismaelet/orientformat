<?php

$solution = ['H', 'C', 'E'];
$answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

include_once(__DIR__ . '/../' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '.php');

\App\Legacy\StyleLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
\App\Legacy\ScriptLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
