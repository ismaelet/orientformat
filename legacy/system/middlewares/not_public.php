<?php

$public = sysData('static') ?: \Legacy\System\Classes\LegacyDB::find('value FROM variables WHERE name=?', ['public']);

if ($public) redirect_old('/');
