<?php

use App\Legacy\LegacyDB;

$public = sysData('static') ?: LegacyDB::find('value FROM variables WHERE name=?', ['public']);

if (! $public && ! $user->admin) {
    redirect_old('/offline');
}
