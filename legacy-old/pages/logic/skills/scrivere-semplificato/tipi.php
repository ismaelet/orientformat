<?php

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
