<?php

\Legacy\System\Classes\StyleLoader::add('profile/stili/' . test()->slug, 'page');

$title = 'Modi<br>di essere';

include_once(__DIR__ . '/../stili/' . test()->slug . '.php');
