<?php



/* TEMPORARY */
//populate the testId field in "progress"
/*$resTemp = DB::select('id, sectionID, step FROM progress WHERE testId=0');

while ($rowTemp = $resTemp->fetch_assoc()) {
	$tempTestId = DB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$rowTemp['sectionID'], $rowTemp['step']]);
	DB::update('progress SET testId = ? WHERE id = ?', [$tempTestId, $rowTemp['id']]);
}*/

//populate the "progress_sections" table
/*$resTemp = DB::select('id FROM users WHERE id NOT IN (SELECT userId FROM progress_sections)');

while ($rowTemp = $resTemp->fetch_assoc()) {

	$resTempSections = DB::select('id FROM sections WHERE id IN (SELECT sectionID FROM progress WHERE userID = ?)', [$rowTemp['id']]);

	while ($rowTempSection = $resTempSections->fetch_assoc()) {
		$tempProgress = DB::row('MAX(step) as maxStep FROM progress WHERE sectionId = ? AND userID = ?', [$rowTempSection['id'], $rowTemp['id']])['maxStep'];

		$rowTempTest = DB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$rowTempSection['id'], $tempProgress]);

		$tempCompleted = DB::count('tests WHERE sectionId = ?', [$rowTempSection['id']]) <= $tempProgress + 1 ? 1 : 0;

		DB::add('progress_sections (userId, sectionId, checkpointId, checkpointStep, completed) VALUES (?,?,?,?,?)', [$rowTemp['id'], $rowTempSection['id'], $rowTempTest, $tempProgress, $tempCompleted]);
	}
}*/

/* END */

//fetch this area data
$area = DB::row('* FROM areas WHERE slug = ?', [basename($_SERVER['REQUEST_URI'])]);

$this->loc = $area['slug'];

//select sections
$sections = [];

$res = $user->schoolClassId ?
	DB::select('* FROM sections WHERE area = ? AND active=1 AND id IN (' . $user->schoolClass->path->sectionIdsStr . ') ORDER BY id ASC', $area['id']) :
	DB::select('* FROM sections WHERE area = ? AND active=1 ORDER BY id ASC', $area['id']);

while ($row = $res->fetch_assoc()) {
	$row['img'] = 'section' . $row['id'] . '.svg';
	$sections[] = $row;
}
