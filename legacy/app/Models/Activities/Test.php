<?php

namespace LegacyModels\Activities;

use LegacyModels\OldModel;

class Test extends OldModel {
	/**
	 * Table name
	 */
	protected const TABLE = 'activities_tests';
	protected const TABLE_LINKS = [
		Area::class => 'areaId',
		Section::class => 'sectionId',
	];

	/**
	 * Settable
	 */
	protected const SETTABLE = [
		'areaId' => ['type' => 'int', 'link' => Area::class],
		'sectionId' => ['type' => 'int', 'link' => Section::class],
		'step' => ['type' => 'int'],
		'title' => ['type' => 'string'],
		'description' => ['type' => 'string'],
		'shortDescription' => ['type' => 'string'],
		'slug' => ['type' => 'string'],
		'template' => ['type' => 'string'],
		'reviewResult' => ['type' => 'bool'],
		'completeSection' => ['type' => 'bool'],
		'active' => ['type' => 'bool'],
	];

	/**
	 * Get methods
	 */
	public static function newFromStep(int $legacySectionId, int $step) {
		return self::newWhere([Test::linkedIndexName(Section::class) => $legacySectionId, 'step' => $step]);
	}

	public function section() {
		return $this->sectionId() ? new Section($this->sectionId()) : null;
	}
}
