<?php

namespace app\Models\Activities;

use app\Models\Model;

class Test extends Model {
	/**
	 * Table name
	 */
	protected const TABLE = 'activities_tests';
	protected const TABLE_LINKS = [
		Area::class => 'areaId',
		Section::class => 'sectionId',
	];

	public static function newFromStep(int $sectionId, int $step) {
		return self::newWhere([Test::linkedIndexName(Section::class) => $sectionId, 'step' => $step]);
	}
}
