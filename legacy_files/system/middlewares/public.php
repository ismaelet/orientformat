<?php

$public = sysData('static') ?: \System\Classes\DBOld::find('value FROM variables WHERE name=?', ['public']);

if (!$public && !$user->admin) redirect_old('/offline');
