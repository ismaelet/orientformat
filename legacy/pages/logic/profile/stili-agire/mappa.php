<?php

StyleLoader::add('profile/stili/' . test()->slug, 'page');

$title = 'Modi di agire';

include_once(__DIR__ . '/../stili/' . test()->slug . '.php');
