<?php

use App\Helpers\TestResultHelper;
use Illuminate\Support\Facades\Auth;

$emotions = [
	__('fear'),
	__('fright'),
	__('surprise'),
	__('disappointment'),
	__('sadness'),
	__('remorse'),
	__('disgust'),
	__('contempt'),
	__('anger'),
	__('aggressiveness'),
	__('anticipation'),
	__('optimism'),
	__('joy'),
	__('love'),
	__('acceptance'),
	__('submission')
];
$step = 3;

dd(TestResultHelper::getResult(Auth::id(), test()->id));

include_once('ruota.php');
