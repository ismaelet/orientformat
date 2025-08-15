<?php

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

$sectionId = \App\Legacy\LegacyView::getInstance()->get('sectionId');
$areaId = \App\Legacy\LegacyView::getInstance()->get('sectionId');
$page = \App\Legacy\LegacyView::getInstance()->get('page');

$legacySection = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $legacySection->id ?
	$legacySection->newSection()->url() :
	route('activities.grades.index');
