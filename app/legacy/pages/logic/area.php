<?php

use Illuminate\Support\Facades\DB;

// fetch this area data
$area = (array) DB::selectOne('SELECT '.('* FROM areas WHERE slug = ?').' LIMIT 1', (array) ([basename($_SERVER['REQUEST_URI'])])) ?: null;

$this->loc = $area['slug'];

// select sections
$legacySections = [];

$res = $user->schoolClassId ?
    array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM sections WHERE area = ? AND active=1 AND id IN ('.$user->schoolClass->path->sectionIdsStr.') ORDER BY id ASC'), (array) ($area['id']))) :
    array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM sections WHERE area = ? AND active=1 ORDER BY id ASC'), (array) ($area['id'])));

while ($row = array_shift($res)) {
    $row['img'] = 'section'.$row['id'].'.svg';
    $legacySections[] = $row;
}
