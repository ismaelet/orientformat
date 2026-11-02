<?php

use App\Legacy\LegacyDB;

/* TEMPORARY */
// populate the testId field in "progress"
/*$resTemp = \App\Legacy\LegacyDB::select('id, sectionID, step FROM progress WHERE testId=0');

while ($rowTemp = $resTemp->fetch_assoc()) {
    $tempTestId = \App\Legacy\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$rowTemp['sectionID'], $rowTemp['step']]);
    \App\Legacy\LegacyDB::update('progress SET testId = ? WHERE id = ?', [$tempTestId, $rowTemp['id']]);
}*/

// populate the "progress_sections" table
/*$resTemp = \App\Legacy\LegacyDB::select('id FROM users WHERE id NOT IN (SELECT userId FROM progress_sections)');

while ($rowTemp = $resTemp->fetch_assoc()) {

    $resTempSections = \App\Legacy\LegacyDB::select('id FROM sections WHERE id IN (SELECT sectionID FROM progress WHERE userID = ?)', [$rowTemp['id']]);

    while ($rowTempSection = $resTempSections->fetch_assoc()) {
        $tempProgress = \App\Legacy\LegacyDB::row('MAX(step) as maxStep FROM progress WHERE sectionId = ? AND userID = ?', [$rowTempSection['id'], $rowTemp['id']])['maxStep'];

        $rowTempTest = \App\Legacy\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$rowTempSection['id'], $tempProgress]);

        $tempCompleted = \App\Legacy\LegacyDB::count('tests WHERE sectionId = ?', [$rowTempSection['id']]) <= $tempProgress + 1 ? 1 : 0;

        \App\Legacy\LegacyDB::add('progress_sections (userId, sectionId, checkpointId, checkpointStep, completed) VALUES (?,?,?,?,?)', [$rowTemp['id'], $rowTempSection['id'], $rowTempTest, $tempProgress, $tempCompleted]);
    }
}*/

/* END */

// fetch this area data
$area = LegacyDB::row('* FROM areas WHERE slug = ?', [basename($_SERVER['REQUEST_URI'])]);

$this->loc = $area['slug'];

// select sections
$legacySections = [];

$res = $user->schoolClassId ?
    LegacyDB::select('* FROM sections WHERE area = ? AND active=1 AND id IN ('.$user->schoolClass->path->sectionIdsStr.') ORDER BY id ASC', $area['id']) :
    LegacyDB::select('* FROM sections WHERE area = ? AND active=1 ORDER BY id ASC', $area['id']);

while ($row = $res->fetch_assoc()) {
    $row['img'] = 'section'.$row['id'].'.svg';
    $legacySections[] = $row;
}
