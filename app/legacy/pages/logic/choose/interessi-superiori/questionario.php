<?php

\App\Legacy\StyleLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
\App\Legacy\ScriptLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');

include_once(__DIR__ . '/../' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '.php');
