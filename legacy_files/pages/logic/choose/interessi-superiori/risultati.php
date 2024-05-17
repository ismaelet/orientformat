<?php

StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');
