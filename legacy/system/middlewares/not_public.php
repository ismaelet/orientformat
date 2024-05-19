<?php

$public = sysData('static') ?: \App\Legacy\LegacyDB::find('value FROM variables WHERE name=?', ['public']);

if ($public) redirect_old('/');
