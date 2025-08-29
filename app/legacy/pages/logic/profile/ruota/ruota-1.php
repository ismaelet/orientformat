<?php

use App\Helpers\Tests\RuotaHelper;

$emotions = RuotaHelper::emotions(request()->test);
$step = 1;

include_once('ruota.php');
