<?php

namespace Grade;

use LegacyDB;

class Path {
	public $id = null;
	public $name;
	public $legacySectionIdsStr;
	public $areaIdsStr;

	function __construct($id) {
		if ($row = \Legacy\System\Classes\LegacyDB::row('* FROM paths WHERE id=?', [$id])) {
			$this->id = $id;
			$this->name = $row['name'];
			$this->sectionIdsStr = $row['sectionIds'];
			$this->areaIdsStr = $row['areaIds'];
		}
	}

	function __get($name) {
		switch ($name) {
			case 'sectionIdsSql':
				return $this->sectionIdsSql = '"' . $this->sectionIdsStr . '"';
				break;
		}
	}
}
