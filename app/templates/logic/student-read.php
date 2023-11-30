<?php

use Activity\Area;
use Activity\Section;

$sectionId = View::getInstance()->get('sectionId');
$areaId = View::getInstance()->get('sectionId');

$section = new Section($sectionId);
$area = new Area($areaId);

$returnLink = $section->id ?
	client_url('/profile/section?id=' . $section->id) :
	client_url('/activities');
