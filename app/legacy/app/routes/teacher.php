<?php

// teacher panel

use \Legacy\Activity\Area;

\App\Legacy\LegacyRoute::add('/teacher/know-more', function () {
    return \App\Legacy\LegacyView::setPage('teacher/know-more')
        ->addMiddlewares(['teacherOrAdministrator'])
        ->setTitle('Saperne di più')
        ->show();
});

\App\Legacy\LegacyRoute::add('/teacher/paths', function () {
    return \App\Legacy\LegacyView::setPage('teacher/paths')
        ->addMiddlewares(['teacherOrAdministrator'])
        ->setTitle('Percorsi')
        ->show();
});


// read more
\App\Legacy\LegacyRoute::add('/read', function () {
    $id = $_GET['id'] ?? null;
    $areaId = $_GET['area-id'] ?? null;

    if ($id) $legacySection = \App\Legacy\LegacyDB::find('slug FROM sections WHERE id=?', $id);
    if ($areaId) $area = \App\Legacy\LegacyDB::find('slug FROM ' . Area::TABLE . ' WHERE id=?', $areaId);

    $page = $id ? $legacySection : 'area-' . $area;

    if (!$page) {
        redirect_old('/');
    }

    return \App\Legacy\LegacyView::setPage('read/' . $page)
        ->setTemplate('read')
        ->show();
});
