<?php

$public = sysData('static') ?: \Legacy\System\Classes\LegacyDB::find('value FROM variables WHERE name=?', ['public']);

if (!$public && !$user->admin) redirect_old('/offline');
