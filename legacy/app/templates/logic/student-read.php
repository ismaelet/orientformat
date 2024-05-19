<?php

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

$sectionId = \Legacy\System\Classes\LegacyView::getInstance()->get('sectionId');
$areaId = \Legacy\System\Classes\LegacyView::getInstance()->get('sectionId');

$section = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $section->id ?
	client_url('/profile/section?id=' . $section->id) :
	client_url('/activities');
