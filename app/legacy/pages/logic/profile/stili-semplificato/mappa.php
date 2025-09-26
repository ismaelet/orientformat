<?php

\App\Legacy\StyleLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');

$resultOrder = [1, 3, 2, 4];

include_once(__DIR__ . '/../' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '.php');
