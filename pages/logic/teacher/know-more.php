<?php

use Activity\Area;

$areas = rows_to_objects(DB::select('id FROM ' . Area::TABLE . ' ORDER BY id ASC'), Area::class);
