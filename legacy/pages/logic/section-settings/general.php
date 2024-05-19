<?php

$public = \Legacy\System\Classes\LegacyDB::find('value FROM config WHERE name=?', ['public']);

if (isset($_POST['public'])) {

	foreach ($_POST['cbx_public'] as $public);

	\Legacy\System\Classes\LegacyDB::update('variables SET value=? WHERE name=?', [$public, 'public']);
}
