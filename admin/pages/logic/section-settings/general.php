<?php

$public = DB::find('value FROM config WHERE name=?', ['public']);

if (isset($_POST['public'])) {

	foreach ($_POST['cbx_public'] as $public);

	DB::update('variables SET value=? WHERE name=?', [$public, 'public']);
}
