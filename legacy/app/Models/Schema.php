<?php

namespace LegacyModels;

use App\Support\Database\Blueprint;
use Closure;
use LegacyDB;

class Schema {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = '';

	/**
	 * Returns the name of the model's table
	 * 
	 * @return string
	 */

	public static function table(): string {
		return static::TABLE;
	}

	/**
	 * Check if the model's table exists
	 * 
	 * @return bool
	 */

	public static function tableExists(): bool {
		return \Legacy\System\Classes\LegacyDB::table(static::table());
	}

	/**
	 * Create the table
	 * 
	 * @return void
	 */
	public static function create(Closure $prepareBlueprint): void {
		$blueprint = new Blueprint;

		$prepareBlueprint($blueprint);

		$columnsQuery = implode(',', $blueprint->columns());

		\Legacy\System\Classes\LegacyDB::execute('CREATE TABLE IF NOT EXISTS ' . static::table() . ' (' . $columnsQuery . ')');
	}

	/**
	 * Fetch the maximum value of a column in the table
	 */

	public static function max(string $column): int {
		$response = \Legacy\System\Classes\LegacyDB::row('MAX(' . $column . ') as maxId FROM ' . static::table());

		return $response['maxId'] ?: 0;
	}

	/**
	 * Set the restrictions for the next query
	 * 
	 * @param string $column the column name
	 * @param string $value the filter value
	 * @return object|array|null
	 */
	public static function findWhere(array $parameters) {
		$id = \Legacy\System\Classes\LegacyDB::find('id FROM ' . static::table() . ' WHERE ' . self::sqlWherelFields($parameters), array_values($parameters));

		return $id ? $instances[] = new static($id) : null;
	}

	/**
	 * Set the restrictions for the next query
	 * 
	 * @param string $column the column name
	 * @param string $value the filter value
	 * @return object|array|null
	 */
	public static function where(array $parameters) {
		$instances = [];
		$rows = \Legacy\System\Classes\LegacyDB::select('id FROM ' . static::table() . ' WHERE ' . self::sqlWherelFields($parameters), array_values($parameters));

		if ($rows->num_rows) {
			while ($row = $rows->fetch_assoc()) {
				$instances[] = new static($row['id']);
			}

			return $instances;
		}

		return null;
	}

	/**
	 * Add a new row
	 * 
	 * @param array $parameters like ['column' => $value, ...]
	 * @return int returns the ID of the inserted row
	 */

	public static function add(array $parameters): int {
		$columns = implode(',', array_keys($parameters));
		$placeHolders = implode(',', array_fill(0, count($parameters), '?'));

		return \Legacy\System\Classes\LegacyDB::add(static::table() . ' (' . $columns . ') VALUES (' . $placeHolders . ')', array_values($parameters));
	}

	/**
	 * Delete all the rows matching some parameters
	 * 
	 */
	public static function deleteWhere(array $parameters) {
		return \Legacy\System\Classes\LegacyDB::delete(static::table() . ' WHERE ' . self::sqlWherelFields($parameters), array_values($parameters));
	}

	/**
	 * 
	 */
	private static function sqlWherelFields(array $parameters) {
		return implode(' AND ', array_map(function ($column) {
			return $column . ' = ?';
		},	array_keys($parameters)));
	}

	protected static function sqlSetFields(array $parameters) {
		return implode(', ', array_map(function ($column) {
			return $column . ' = ?';
		},	array_keys($parameters)));
	}

	/*

	/**
	 * @property object the singleton instance
	 
	protected static $instance;

	/**
	 * @property array WHERE clause of the next query 
	 
	protected static $where = [];

	/**
	 * Construct magic method
	 
	private function __construct() {
	}

	/**
	 * Check if the column exists
	 * 
	 * @return bool
	 */

	public static function columnExists(string $column): bool {
		return \Legacy\System\Classes\LegacyDB::execute("SHOW COLUMNS FROM " . static::table() . " LIKE '" . $column . "'")->num_rows;
	}

	/**
	 * Alter a table
	 */
	public static function alter(Closure $prepareBlueprint): void {
		// blue print
		$blueprint = new Blueprint;
		$prepareBlueprint($blueprint);

		// columns to add
		$addColumns = $blueprint->columns();

		array_walk($addColumns, function (&$columnQuery, $column) {
			if (!self::columnExists($column)) {
				$columnQuery = 'ADD COLUMN ' . $columnQuery;
			} else {
				$columnQuery = null;
			}
		});

		// columns to drop
		$dropColumns = array_map(function ($column) {
			if (self::columnExists($column)) {
				return 'DROP COLUMN ' . $column;
			} else {
				return null;
			}
		}, $blueprint->toDrop());

		$columnsQuery = (implode(', ', array_filter(condense_array($addColumns, $dropColumns))));

		\Legacy\System\Classes\LegacyDB::execute('ALTER TABLE ' . static::table() . ' ' . $columnsQuery);
	}

	/**
	 * Create an instance of the item mathing the ID
	 * 
	 * @param int $id
	 * @return object | null returns the first matching item or false if no match was found
	 */

	public static function find(int $id) {
		if (\Legacy\System\Classes\LegacyDB::exists(static::table() . ' WHERE id = ?', [$id])) {
			return new static($id);
		}

		return null;
	}
	/**
	 * Set the restrictions for the next query
	 * 
	 * @param string $column the column name
	 * @param string $value the filter value
	 * @return object
	 
	public function first(): object {
		$query = \Legacy\System\Classes\LegacyDB::getInstance()->table(static::table());

		foreach (static::$where as $column => $value) {
			$query->where($column, $value);
		}

		$standardClass = $query->first();

		self::cleanup();

		return $standardClass ? new static($standardClass->id) : null;
	}

	/**
	 * Fetch all the rows matching some parameters
	 * 
	 * @param string $column the column name
	 * @param string $value the filter value
	 * @return array | bool returns all the matching rows or false if no match was found
	 
	public static function allWhere(string $column, $value) {
		return \Legacy\System\Classes\LegacyDB::getInstance()->execute('SELECT * FROM ' . static::table() . ' WHERE ' . $column . ' = ?', [$value]);
	}

	/**
	 * Clean the data relative to the current query
	 * 
	 * @return void
	 
	private static function cleanup(): void {
		self::$where = [];
	}*/
}
