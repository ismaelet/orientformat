<?php

namespace App\Models;

use DB;
use Exception;

abstract class Model extends Schema {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = '';

	/**
	 * @property array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = [];

	/**
	 * @property int the index value of the istance
	 */
	protected $id;

	/**
	 * @property array the list of the database columns
	 */
	protected $columns = [];

	/**
	 * @property array the list of the values fetched form the database, structured as ['column_name' => value, ...]
	 */
	protected $databaseData = [];

	/**
	 * @property array the list of the cached values
	 */
	protected $cache = [];

	/**
	 * Initialize the istance
	 */
	public function __construct(int $id) {
		$this->initialize($id);
	}

	protected function initialize(int $id) {
		$databaseData = DB::row('* FROM ' . static::table() . ' WHERE id = ?', [$id]);

		if ($databaseData) {
			$this->id = $id;
			$this->databaseData = $databaseData;
			$this->columns = array_keys($this->databaseData);
		}
	}

	/**
	 * Set magic method
	 */
	function __get(string $property) {
		$property = !in_array($property, $this->columns) ? camel_case_to_snake_case($property) : $property;

		if (!$this->id) {
			return null;
		} else if (isset($this->cache[$property])) {
			return $this->cache[$property];
		} else if (isset($this->databaseData[$property])) {
			return $this->databaseData[$property];
		}

		throw new Exception('Property ' . $property . ' not found in ' . self::class);
	}

	/**
	 * Set magic method
	 */
	function __set(string $property, $value) {
		$this->set([$property => $value]);
	}

	/**
	 * Push the edits to the database
	 * 
	 * @property array $properties a list of the properties to set as ['propertyName' => $value, ...]
	 * @return object self
	 */
	public function set(array $properties): self {
		foreach ($properties as $property => $value) {
			if (in_array($property, array_keys(static::SETTABLE))) {
				$databaseProperty = !in_array($property, $this->columns) ? camel_case_to_snake_case($property) : $property;

				// type check
				switch (static::SETTABLE[$property]) {
					case 'string':
						if (!is_string($value)) {
							throw new Exception('Trying to set ' . $property . ' to a non-string value in ' . static::class);
						}
						break;
				}

				// set the value
				$this->cache[$databaseProperty] = $value;
				$this->databaseData[$databaseProperty] = $value;
			} else {
				throw new Exception('Property ' . $property . ' of ' . static::class . ' is not settable');
			}
		}

		return $this;
	}

	/**
	 * Push the edits to the database
	 * 
	 * @return object self
	 */
	public function save(): self {
		$parameters = array_filter($this->cache, function ($propertyName) {
			return in_array($propertyName, $this->columns);
		}, ARRAY_FILTER_USE_KEY);

		$fields = self::sqlSetFields($parameters);

		array_push($parameters, $this->id);

		DB::update($this->table() . ' SET ' . $fields . ' WHERE id = ?', array_values($parameters));

		return $this;
	}

	/**
	 * Delete
	 */
	public function delete(): void {
		DB::delete($this->table() . ' WHERE id = ?', [$this->id]);
	}
}
