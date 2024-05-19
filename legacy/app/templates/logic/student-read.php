<?php

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

$legacySectionId = \Legacy\System\Classes\LegacyView::getInstance()->get('sectionId');
$areaId = \Legacy\System\Classes\LegacyView::getInstance()->get('sectionId');

$legacySection = new Section($legacySectionId);
$area = new Area($areaId);

$returnLink = $legacySection->id ?
	client_url('/profile/section?id=' . $legacySection->id) :
	client_url('/activities');
