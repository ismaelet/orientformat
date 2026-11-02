<?php

use Illuminate\Support\Facades\DB;
use Legacy\Activity\Area;

$areas = rows_to_objects(array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id FROM '.Area::TABLE.' ORDER BY id ASC'), (array) ([]))), Area::class);
