<?php

namespace app\Models;

use DB;
use Exception;

abstract class OldModel extends DatabaseModel {
	/**
	 * Database
	 */
	// protected const SETTABLE = ['column' => ['type' => Type, 'link' => ModuleName::class],];
	protected const SETTABLE = [];

	/**
	 * Model paramenters
	 */
	protected $id;
	protected $databaseData = [];
	protected $dynamicData = [];
	protected $preparedData = [];

	/**
	 * Initialize
	 */
	function __construct(int $id) {
		$this->id = $id;
		$this->databaseData = DB::row('* FROM ' . static::TABLE . ' WHERE ' . self::indexName() . ' = ?', [$id]) ?: [];
	}

	function __call($methodName, $arguments) {
		if (strpos($methodName, 'set') === 0) {
			return $this->set($methodName, $arguments);
		} else if (array_key_exists($methodName, $this->databaseData)) {
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

	public static function newEmpty() {
		return new static(0);
	}

	/**
	 * Post methods
	 */
	public function prepare($property, $arguments) {
		if (in_array($property, array_keys(static::SETTABLE))) {
			switch (static::SETTABLE[$property]['type'] ?? null) {
				case 'bool':
					$value = $arguments ? 1 : 0;
					break;

				default:
					$value = $arguments;
			}
		} else {
			throw new Exception("Property $property can't be set in " . static::class);
		}

		$this->preparedData[$property] = $value;

		return $this;
	}

	public function up() {
		return static::add($this->preparedData);
	}

	public function post() {
		// columns
		$columnQuery = array_map(function ($column) {
			return $column . ' = ?';
		}, array_keys($this->preparedData));

		$columnQuery = implode(',', $columnQuery);

		// values
		$values = array_values($this->preparedData);
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
