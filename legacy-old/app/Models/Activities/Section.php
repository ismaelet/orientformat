<?php

namespace app\Models\Activities;

use app\Models\OldModel;
use DB;

class Section extends OldModel {
	/**
	 * Table data
	 */
	protected const TABLE = 'activities_sections';
	protected const TABLE_LINKS = [
		Area::class => 'areaId',
	];

	/**
	 * Get methods
	 */
	public static function newFromSlug(string $slug) {
		return self::newWhere(['slug' => $slug]);
	}
}
