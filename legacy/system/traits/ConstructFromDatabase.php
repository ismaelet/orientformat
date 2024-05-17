<?php

namespace System\Traits;

use ConnectionInterface;
use DBOld;

trait ConstructFromDatabase {

	private $databaseEntry = [];

	function __construct(int $id = null) {
		$index = self::INDEX ?? 'id';
		$data = \System\Classes\DBOld::row('* FROM ' . self::TABLE . ' WHERE ' . $index . ' = ?', [$id]);

		if ($data) {
			$this->databaseEntry = $data;
		} else {
			$columns = \System\Classes\DBOld::select('COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?', [\System\Classes\ConnectionInterface::getInstance()->database, self::TABLE]);

			while ($column = $columns->fetch_assoc()) {
				$this->databaseEntry[$column['COLUMN_NAME']] = null;
			}
		}
	}
}
