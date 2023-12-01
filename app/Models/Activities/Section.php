<?php

namespace app\Models\Activities;

use app\Models\Model;
use DB;

class Section extends Model {
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
