<?php

use App\Legacy\LegacyView;
use Legacy\Activity\Area;
use Legacy\Activity\Section;

$sectionId = LegacyView::getInstance()->get('sectionId');
$areaId = LegacyView::getInstance()->get('sectionId');
$page = LegacyView::getInstance()->get('page');

$legacySection = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $legacySection->id ?
    $legacySection->newSection()->url() :
    route('activities.grades.index');
