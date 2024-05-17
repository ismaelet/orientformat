<?php

use \Legacy\Activity\Area;

$areas = rows_to_objects(\System\Classes\DBOld::select('id FROM ' . Area::TABLE . ' ORDER BY id ASC'), Area::class);
