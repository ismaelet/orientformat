<?php

use Legacy\Activity\Area;
use Legacy\Activity\Section;

$viewData = legacy_view_data();
$sectionId = $viewData['sectionId'] ?? null;
$areaId = $viewData['areaId'] ?? null;
$page = $viewData['page'] ?? null;

$legacySection = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $legacySection->id ?
    $legacySection->newSection()->url() :
    route('activities.grades.index');
