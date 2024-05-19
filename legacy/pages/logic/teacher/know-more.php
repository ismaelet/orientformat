<?php

use \Legacy\Activity\Area;

$areas = rows_to_objects(\Legacy\System\Classes\LegacyDB::select('id FROM ' . Area::TABLE . ' ORDER BY id ASC'), Area::class);
