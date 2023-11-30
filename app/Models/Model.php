<?php

namespace app\Models;

use DB;
use Exception;

abstract class Model extends DatabaseModel {
	/**
	 * Model paramenters
	 */
	protected $id;
	protected $databaseData = [];
	protected $dynamicData;

	/**
	 * Initialize
	 */
	function __construct(int $id) {
		$this->id = $id;
		$this->databaseData = DB::row('* FROM ' . static::TABLE . ' WHERE ' . self::indexName() . ' = ?', [$id]) ?: [];
	}

	function __call($methodName, $arguments) {
		if (array_key_exists($methodName, $this->databaseData)) {
			return $this->databaseData[$methodName];
		}

		throw new Exception("database property $methodName not set");
	}

	/**
	 * Get methods
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Post methods
	 */
	public function post(array $parameters) {
		// columns
		$columnQuery = array_map(function ($column) {
			return $column . ' = ?';
		}, array_keys($parameters));

		$columnQuery = implode(',', $columnQuery);

		// values
		$values = array_values($parameters);
		array_push($values, $this->id);

		// execute
		DB::update(static::TABLE . ' SET ' . $columnQuery . ' WHERE ' . self::indexName() . ' = ?', $values);
	}

	/**
	 * Delete method
	 */
	public function delete() {
		DB::delete(static::table() . ' WHERE ' . static::indexName() . ' = ?', [$this->id]);
	}
}
