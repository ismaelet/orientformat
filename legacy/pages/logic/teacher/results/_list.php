<?php

// theme
$this->styles->add(SERVER_ROOT . '/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT . '/pages/scripts/teacher/teacher.js');

// fetch class
$grade = \Legacy\System\Classes\LegacyDB::find('class FROM users WHERE id = ?', [$user->id]);

// fetch data
$students = \Legacy\System\Classes\LegacyDB::select('*, CONCAT(lastname," ",firstname) as name FROM users WHERE class = ? AND level=0 AND status=1 ORDER BY lastname ASC, firstname ASC, id ASC', [$grade]);

$res = \Legacy\System\Classes\LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

while ($choice = $res->fetch_assoc()) $choices[$choice['id']] = $choice['advice'];

// add advice
if (isset($_POST['add-advice'])) {

	$advices = [];

	foreach ($_POST['advice'] as $advice) if ($advice) $advices[] = $advice;

	$advices = implode(',', $advices);

	if (empty($advices))
		\Legacy\System\Classes\LegacyDB::delete('advices WHERE userID = ?', $_POST['id']);
	else if (\Legacy\System\Classes\LegacyDB::exists('advices WHERE userID = ?', $_POST['id']))
		\Legacy\System\Classes\LegacyDB::update('advices SET advices = ? WHERE userID = ?', [$advices, $_POST['id']]);
	else
		\Legacy\System\Classes\LegacyDB::add('advices (userID, advices) VALUES (?, ?)', [$_POST['id'], $advices]);
}
