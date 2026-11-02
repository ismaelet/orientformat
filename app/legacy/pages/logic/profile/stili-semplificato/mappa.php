<?php

use App\Legacy\StyleLoader;

StyleLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');

$resultOrder = ['Visivo', 'Collaborativo', 'Uditivo', 'Autonomo'];

include_once __DIR__.'/../'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug.'.php';
