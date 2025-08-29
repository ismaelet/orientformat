<?php

use App\Helpers\Tests\RuotaHelper;

$emotions = RuotaHelper::emotions(request()->test);
$step = 2;

include_once('ruota.php');
