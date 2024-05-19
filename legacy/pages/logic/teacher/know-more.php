<?php

use \Legacy\Activity\Area;

$areas = rows_to_objects(\App\Legacy\LegacyDB::select('id FROM ' . Area::TABLE . ' ORDER BY id ASC'), Area::class);
