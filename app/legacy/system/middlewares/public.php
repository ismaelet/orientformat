<?php

use Illuminate\Support\Facades\DB;

$public = sysData('static') ?: DB::scalar('SELECT '.('value FROM variables WHERE name=?').' LIMIT 1', (array) (['public'])) ?? false;

if (! $public && ! $user->admin) {
    redirect_old('/offline');
}
