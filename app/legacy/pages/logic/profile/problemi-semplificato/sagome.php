<?php

use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;

$solution = ['H', 'C', 'E'];
$answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

include_once __DIR__.'/../'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug.'.php';

StyleLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');
ScriptLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');
