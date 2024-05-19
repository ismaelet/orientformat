<?php

// setup page
$tbl = 'students';
$index = 'userId';
$index_show = 'name';
$query['select'] = '*, CONCAT(firstname, " ", lastname) as name';
$query['from'] = 'students INNER JOIN users ON students.userId = users.id';

// form
$inputs = [
	[
		['type' => 'lbl', 'text' => 'Username'],
		['name' => 'username', 'text' => 'Username', 'readonly' => true],
	],
	[
		['type' => 'lbl', 'text' => 'Nome e cognome'],
		['name' => 'firstname', 'text' => 'Nome', 'size' => 2, 'readonly' => true],
		['name' => 'lastname', 'text' => 'Cognome', 'size' => 2, 'readonly' => true],
	],
	[
		['type' => 'lbl', 'text' => 'Genera una nuova password'],
		['name' => 'new-password', 'text' => 'Nuova password', 'size' => 3, 'readonly' => true],
		['type' => 'btn', 'custom-class' => 'pbtn--c2 js-generate-password', 'text' => 'Reset password', 'size' => 1]
	],
];

// edit
function _expand_edit($tbl, $inputs, $index, $id) {
	$newPassword = $_POST['new-password'];

	if ($newPassword) \Legacy\System\Classes\LegacyDB::update('users SET password=? WHERE id=?', [$newPassword, $_GET['id']]);
}
