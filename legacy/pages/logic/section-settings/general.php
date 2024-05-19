<?php

$public = \App\Legacy\LegacyDB::find('value FROM config WHERE name=?', ['public']);

if (isset($_POST['public'])) {

	foreach ($_POST['cbx_public'] as $public);

	\App\Legacy\LegacyDB::update('variables SET value=? WHERE name=?', [$public, 'public']);
}
