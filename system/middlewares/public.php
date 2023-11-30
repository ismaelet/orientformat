<?php

$public = sysData('static') ?: DB::find('value FROM variables WHERE name=?', ['public']);

if (!$public && !$user->admin) redirect('/offline');