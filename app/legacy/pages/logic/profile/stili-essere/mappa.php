<?php

\App\Legacy\StyleLoader::add('profile/stili/' . legacy_test()->slug, 'page');

$title = 'Modi<br>di essere';

$resultOrder = ['Semplicità', 'Giocoso', 'Divergente', 'Esplorativo', 'Complessità', 'Finalistico', 'Convergente', 'Evitante'];

include_once(__DIR__ . '/../stili/' . legacy_test()->slug . '.php');
