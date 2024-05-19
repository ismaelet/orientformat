<?php

namespace Legacy\Activity;

use DatabaseObject;
use LegacyDB;

class Area {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'activities_areas';
	public const INDEX = 'id';

	/**
	 * Get methods
	 */
	private function getIcon() {
		return APP_ICONS_DIR . '/areas/area-' . $this->id;
	}

	public function getSections($yearNumber = null) {
		if ($yearNumber) {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, years)', [$this->id, $yearNumber]), Section::class);
		} else {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND ' . Section::AREA_INDEX . ' = ?', [$this->id]), Section::class);
		}
	}

	public function getAlphabeticalSections($yearNumber = null) {
		if ($yearNumber) {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, years) ORDER BY name ASC', [$this->id, $yearNumber]), Section::class);
		} else {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND ' . Section::AREA_INDEX . ' = ?  ORDER BY name ASC', [$this->id]), Section::class);
		}
	}

	public function getDoableSections($yearNumber = null) {
		if ($yearNumber) {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND isStandard = 1 AND ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, years) ', [$this->id, $yearNumber]), Section::class);
		} else {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND isStandard = 1 AND ' . Section::AREA_INDEX . ' = ?', [$this->id]), Section::class);
		}
	}

	public function getAplhabeticalDoableSections($yearNumber = null) {
		if ($yearNumber) {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND isStandard = 1 AND ' . Section::AREA_INDEX . ' = ? AND FIND_IN_SET(?, years) ORDER BY name ASC', [$this->id, $yearNumber]), Section::class);
		} else {
			return rows_to_objects(\Legacy\System\Classes\LegacyDB::select(Section::INDEX . ' FROM ' . Section::TABLE . ' WHERE active = 1 AND isStandard = 1 AND ' . Section::AREA_INDEX . ' = ? ORDER BY name ASC', [$this->id]), Section::class);
		}
	}

	private function getUrl() {
		return client_url('/' . $this->slug);
	}
}
