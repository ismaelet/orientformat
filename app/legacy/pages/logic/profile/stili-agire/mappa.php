<?php

\App\Legacy\StyleLoader::add('profile/stili/' . legacy_test()->slug, 'page');

$title = 'Modi di agire';

include_once(__DIR__ . '/../stili/' . legacy_test()->slug . '.php');
