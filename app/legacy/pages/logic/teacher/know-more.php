<?php

use App\Legacy\LegacyDB;
use Legacy\Activity\Area;

$areas = rows_to_objects(LegacyDB::select('id FROM '.Area::TABLE.' ORDER BY id ASC'), Area::class);
