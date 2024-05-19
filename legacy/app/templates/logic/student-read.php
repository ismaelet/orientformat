<?php

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

$sectionId = \App\Legacy\LegacyView::getInstance()->get('sectionId');
$areaId = \App\Legacy\LegacyView::getInstance()->get('sectionId');

$legacySection = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $legacySection->id ?
	client_url('/profile/section?id=' . $legacySection->id) :
	client_url('/activities');
