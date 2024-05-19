<?php

\App\Legacy\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
\App\Legacy\ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');
