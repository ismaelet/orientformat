<?php

use App\Legacy\StyleLoader;

include_once __DIR__.'/../'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug.'.php';

StyleLoader::add(legacy_test()->area->slug.'/'.legacy_test()->section->mainSection->slug.'/'.legacy_test()->slug, 'page');
