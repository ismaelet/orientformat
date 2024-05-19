<?php

namespace LegacyModels\Activities;

use LegacyModels\OldModel;
use LegacyDB;

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
