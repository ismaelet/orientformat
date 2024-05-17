<?php

$public = \System\Classes\DBOld::find('value FROM config WHERE name=?', ['public']);

if (isset($_POST['public'])) {

	foreach ($_POST['cbx_public'] as $public);

	\System\Classes\DBOld::update('variables SET value=? WHERE name=?', [$public, 'public']);
}
