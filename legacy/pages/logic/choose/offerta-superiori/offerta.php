<?php

\Legacy\System\Classes\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');

$testResultId = 151;

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');
