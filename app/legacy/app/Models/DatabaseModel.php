<?php

namespace LegacyModels;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Methods that return table structure
 *
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
abstract class DatabaseModel
{
    protected const TABLE = '';

    protected const TABLE_LINKS = [];

    /**
     * Methods that return data
     */
    public static function table()
    {
        return static::TABLE;
    }

    public static function indexName()
    {
        $columns = DB::select('SHOW columns FROM '.static::table().' WHERE `Key` = "PRI"');

        return $columns[0]->Field;
    }

    public static function linkedIndexName(string $modelName)
    {
        return static::TABLE_LINKS[$modelName];
    }

    public static function hasTable()
    {
        return Schema::hasTable(static::table());
    }

    public static function hasColumn(string $column)
    {
        return Schema::hasColumn(static::table(), $column);
    }

    /**
     * Methods that interact with the table structure
     */
    public static function createTable(array $columnsData)
    {
        $columnsQuery = implode(',', $columnsData);

        DB::statement('CREATE TABLE IF NOT EXISTS '.static::table().' ('.$columnsQuery.')');
    }

    public static function dropTable()
    {
        if (static::hasTable()) {
            Schema::drop(static::table());
        }
    }

    public static function addColumns(array $columnsData)
    {
        if (static::hasTable()) {
            foreach ($columnsData as $columnData) {
                $columnQuery = $columnData[0];
                $column = explode(' ', $columnQuery, 2)[0];
                $previousColumns = $columnData[1] ?? null;

                if (! static::hasColumn($column)) {
                    DB::statement('ALTER TABLE '.static::table().' ADD COLUMN '.$columnQuery.($previousColumns ? ' AFTER '.$previousColumns : ''));
                }
            }
        }
    }

    public static function dropColumns(array $columns)
    {
        foreach ($columns as $column) {
            if (static::hasColumn($column)) {
                Schema::table(static::table(), function ($table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }

    public static function transferColumnData($sourceColumn, $destinationColumn)
    {
        DB::table(static::table())->update([$destinationColumn => DB::raw($sourceColumn)]);
    }

    /**
     * Methods that return entries data
     */
    public static function exists($value, $columnName = null)
    {
        $columnName = $columnName ?: self::indexName();

        return DB::table(static::table())->where($columnName, $value)->exists();
    }

    public static function newWhere(array $parameters)
    {
        $id = DB::table(static::table())->where($parameters)->value(static::indexName());

        return $id ? new static($id) : null;
    }

    public static function getAll(array $where = [], int $countLimit = 10, ?string $sortIndex = null, string $sortDirection = 'DESC')
    {
        $sortIndex = $sortIndex ? $sortIndex : static::indexName();

        $rows = DB::table(static::table())->select(static::indexName())->orderBy($sortIndex, $sortDirection)->limit($countLimit)->get();

        foreach ($rows as $row) {
            $objects[] = new static($row->{static::indexName()});
        }

        return $objects;
    }

    public static function list(?string $columnName = null)
    {
        $columnName = $columnName ?: self::indexName();
        $entries = DB::table(static::table())->pluck($columnName);

        return $entries->isNotEmpty() ? $entries->all() : null;
    }

    /**
     * Method that interacts with the entries
     */
    public static function add(array $parameters = [])
    {
        return DB::table(static::table())->insertGetId($parameters, static::indexName());
    }

    public static function newAdd(int $id)
    {
        if (static::exists($id)) {
            return new static($id);
        } else {
            self::add([static::indexName() => $id]);

            return new static($id);
        }
    }

    public static function updateAllInSet($find, $replace, string $column)
    {
        $quotedFind = DB::connection()->getPdo()->quote(','.$find.',');
        $quotedReplace = DB::connection()->getPdo()->quote(','.$replace.',');
        DB::table(static::table())->update([
            $column => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', {$column}, ','), {$quotedFind}, {$quotedReplace}))"),
        ]);
    }

    public static function duplicateEntry(int $id, array $changedParameters = [])
    {
        DB::statement('CREATE TEMPORARY TABLE duplication_table SELECT * FROM '.static::table().' WHERE '.static::indexName().' = ?', [$id]);
        DB::table('duplication_table')->update(array_merge([static::indexName() => null], $changedParameters));
        DB::statement('INSERT INTO '.static::table().' SELECT * FROM duplication_table');

        $id = (int) DB::getPdo()->lastInsertId();

        DB::statement('DROP TEMPORARY TABLE IF EXISTS duplication_table');

        return $id;
    }
}
