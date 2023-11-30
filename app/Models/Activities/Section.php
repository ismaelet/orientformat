<?php

namespace app\Models\Activities;

use app\Models\Model;

class Section extends Model {
	/**
	 * Table data
	 */
	protected const TABLE = 'activities_sections';
	protected const TABLE_LINKS = [
		Area::class => 'areaId',
	];
}
