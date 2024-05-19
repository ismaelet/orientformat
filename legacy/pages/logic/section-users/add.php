<?php

$user = new \App\Legacy\User($_GET['id'] ?? null);

/**
 * Query configuration
 */
$queryConfig['select'] = ['id', 'CONCAT(firstName, " ", lastname) as fullName'];
$queryConfig['table'] = 'users';
$queryConfig['index-field'] = 'id';
$queryConfig['title-field'] = 'fullName';

// form
if (!$user->id) {
	$inputs = [
		[
			['type' => 'lbl', 'text' => 'Indirizzo e-mail (usato anche come username)',],
			['type' => 'email', 'text' => 'Indirizzo e-mail', 'name' => 'email', 'required' => true]
		],
		[
			['type' => 'lbl', 'text' => 'Password',],
			['type' => 'password', 'text' => 'Password', 'name' => 'password', 'required' => true]
		],
		[
			['type' => 'lbl', 'text' => 'Nome e cognome',],
			['text' => 'Nome', 'name' => 'firstName', 'size' => 2,],
			['text' => 'Cognome', 'name' => 'lastName', 'size' => 2,]
		],
		[
			['type' => 'lbl', 'text' => 'Tipologia',],
			[
				'type' => 'select',
				'name' => 'groupId',
				'query' => '* FROM user_groups ORDER BY name ASC',
				'field-name' => 'id',
				'field-show' => 'name',
				'empty' => true
			]
		]
	];
} else {
	$inputs = [
		[
			['type' => 'lbl', 'text' => 'Indirizzo e-mail (usato anche come username)',],
			['type' => 'email', 'text' => 'Indirizzo e-mail', 'name' => 'email', 'value' => $user->email ?: $user->username,  'readonly' => true]
		],
		[
			['type' => 'lbl', 'text' => 'Nome e cognome',],
			['text' => 'Nome', 'name' => 'firstName', 'value' => $user->firstName, 'size' => 2,],
			['text' => 'Cognome', 'name' => 'lastName', 'value' => $user->lastName, 'size' => 2,]
		],
		[
			['type' => 'lbl', 'text' => 'Tipologia',],
			[
				'type' => 'select',
				'value' => $user->groupId,
				'name' => 'groupId',
				'query' => '* FROM user_groups ORDER BY name ASC',
				'field-name' => 'id',
				'field-show' => 'name',
				'empty' => true
			]
		]
	];
}
