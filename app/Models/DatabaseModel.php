<?php

namespace app\Models;

use ConnectionInterface;
use DB;

/**
 * Methods that return table structure
 * @method string table() <return the table name>
 * @method string indexName() <return the primary index of the table>
 * @method string linkedIndexName(string $modelName) <return the index in this table linked to the primary index of the specified module>
 * @method bool hasTable() <check if the table exists>
 * @method bool hasColumn(string $column) <check if the table has the column>
 * 
 * Methods that interact with the table structure
 * @method null createTable(array $columnsData) <create the table>
 * @method null dropTable() <delete the table>
 * @method null addColumns(array $columnsData) <add some columns to the table>
 * @method null dropColumns(array $columns[]) <delete the columns from the table>
 * @method null transferColumnData(string $sourceColumn, string $destinationColumn) <copy of one column and paste it in another column>
 * 
 * Methods that return entries data
 * @method bool exits(mixed $value, string|null $columnName = indexName()) <check if there is a row with the specified column value>
 * @method object newWhere(array $parameters) <generate the first object mathing the parameters>
 * @method array getAll(array $where = [], int $countLimit = 10, string $sortIndex = null, string $sortDirection = 'DESC') <return a list of objects>
 * @method array list(string $columnName = indexName()) <return an array with all the values of the column>
 * 
 * Method that interacts with the entries
 * @method int add(array $parameters) <add an entry to the table>
 * @method object newAdd(int $id) <return the entry matching the ID, if not found add an empty entry to the table based on the ID>
 * @method null updateAllInSet(mixed $find, mixed $replace, string $column) <find and replace all the occurences of a value in a set>
 * @method int duplicateEntry(int $id, array $changedParameters = []) <duplicate a row, with optional changes, return the new ID>
 */
abstract class DatabaseModel {
	protected const TABLE = '';
	protected const TABLE_LINKS = [];

	/**
	 * Methods that return data
	 */
	public static function table() {
		return static::TABLE;
	}

	public static function indexName() {
		return DB::execute('SHOW columns FROM ' . static::table() . ' WHERE `Key` = "PRI"')->res[0]['Field'];
	}

	public static function linkedIndexName(string $modelName) {
		return static::TABLE_LINKS[$modelName];
	}

	public static function hasTable() {
		return DB::table(static::table());
	}

	public static function hasColumn(string $column) {
		return DB::execute('SHOW COLUMNS FROM ' . static::table() . ' LIKE "' . $column . '"')->num_rows;
	}

	/**
	 * Methods that interact with the table structure
	 */
	public static function createTable(array $columnsData) {
		$columnsQuery = implode(',', $columnsData);

		DB::execute('CREATE TABLE IF NOT EXISTS ' . static::table() . ' (' . $columnsQuery . ')');
	}

	public static function dropTable() {
		if (static::hasTable()) {
			DB::execute('DROP TABLE ' . static::table());
		}
	}

	public static function addColumns(array $columnsData) {
		if (static::hasTable()) {
			foreach ($columnsData as $columnData) {
				$columnQuery = $columnData[0];
				$column = explode(' ', $columnQuery, 2)[0];
				$previousColumns = $columnData[1] ?? null;

				if (!static::hasColumn($column)) {
					DB::execute('ALTER TABLE ' . static::table() . ' ADD COLUMN ' . $columnQuery . ($previousColumns ? ' AFTER ' . $previousColumns : ''));
				}
			}
		}
	}

	public static function dropColumns(array $columns) {
		foreach ($columns as $column) {
			if (static::hasColumn($column)) {
				DB::execute("ALTER TABLE " . static::table() . " DROP COLUMN " . $column);
			}
		}
	}

	public static function transferColumnData($sourceColumn, $destinationColumn) {
		DB::update(static::table() . ' set ' . $destinationColumn . ' = ' . $sourceColumn);
	}

	/**
	 * Methods that return entries data
	 */
	public static function exists($value, $columnName = null) {
		$columnName = $columnName ?: self::indexName();

		return DB::exists(static::table() . ' WHERE ' . $columnName . ' = ?', [$value]);
	}

	public static function newWhere(array $parameters) {
		$columnQuery = implode(' AND ', array_map(function ($column) {
			return $column . ' = ?';
		}, array_keys($parameters)));

		$values = array_values($parameters);

		$id = DB::find(static::indexName() . ' FROM ' . static::table() . ' WHERE ' . $columnQuery, $values);

		return $id ? new static($id) : null;
	}

	public static function getAll(array $where = [], int $countLimit = 10, string $sortIndex = null, string $sortDirection = 'DESC') {
		$sortIndex = $sortIndex ? $sortIndex : static::indexName();

		$rows = DB::select(static::indexName() . ' FROM ' . static::table() . ' ORDER BY ' . $sortIndex . ' ' . $sortDirection . ' LIMIT ?', [$countLimit]);

		while ($row = $rows->fetch_assoc()) {
			$objects[] = new static($row[static::indexName()]);
		}

		return $objects;
	}

	public static function list(string $columnName = null) {
		$columnName = $columnName ?: self::indexName();
		$entries = DB::execute('SELECT ' . $columnName . ' FROM ' . static::table());

		return $entries->num_rows ? $entries->extractResults() : null;
	}

	/**
	 * Method that interacts with the entries
	 */
	public static function add(array $parameters = []) {
		$columnNames = implode(',', array_keys($parameters));
		$values = array_values($parameters);

		return DB::add(static::table() . ' (' . $columnNames . ')', $values);
	}

	public static function newAdd(int $id) {
		if (static::exists($id)) {
			return new static($id);
		} else {
			self::add([static::indexName() => $id]);

			return new static($id);
		}
	}

	public static function updateAllInSet($find, $replace, string $column) {
		DB::update(static::table() . " SET " . $column . " = TRIM(BOTH ',' FROM REPLACE(CONCAT(','," . $column . ",','), '," . $find . ",', '," . $replace . ",'))");
	}

	public static function duplicateEntry(int $id, array $changedParameters = []) {
		if (!empty($changedParameters)) {
			$columnQuery = ',' . implode(',', array_map(function ($column) {
				return $column . ' = ?';
			}, array_keys($changedParameters)));
		} else {
			$columnQuery = '';
		}

		$values = array_values($changedParameters);


		DB::execute("CREATE TEMPORARY TABLE duplication_table SELECT * FROM " . static::table() . " WHERE " . static::indexName() . " = ?", [$id]);
		DB::execute("UPDATE duplication_table SET " . static::indexName() . " = NULL " . $columnQuery, $values);
		DB::execute("INSERT INTO " . static::table() . " SELECT * FROM duplication_table");

		$id = (ConnectionInterface::getInstance()->connection)->insert_id;

		DB::execute("DROP TEMPORARY TABLE IF EXISTS duplication_table");

		return $id;
	}
}
