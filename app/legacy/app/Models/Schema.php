<?php

namespace LegacyModels;

use App\Support\Database\Blueprint;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as LaravelSchema;

class Schema
{
    /**
     * @property string the name of the table associated to the model
     */
    protected const TABLE = '';

    /**
     * Returns the name of the model's table
     */
    public static function table(): string
    {
        return static::TABLE;
    }

    /**
     * Check if the model's table exists
     */
    public static function tableExists(): bool
    {
        return LaravelSchema::hasTable(static::table());
    }

    /**
     * Create the table
     */
    public static function create(Closure $prepareBlueprint): void
    {
        $blueprint = new Blueprint;

        $prepareBlueprint($blueprint);

        $columnsQuery = implode(',', $blueprint->columns());

        DB::statement('CREATE TABLE IF NOT EXISTS '.static::table().' ('.$columnsQuery.')');
    }

    /**
     * Fetch the maximum value of a column in the table
     */
    public static function max(string $column): int
    {
        return DB::table(static::table())->max($column) ?: 0;
    }

    /**
     * Set the restrictions for the next query
     *
     * @param  string  $column  the column name
     * @param  string  $value  the filter value
     * @return object|array|null
     */
    public static function findWhere(array $parameters)
    {
        $id = DB::table(static::table())->where($parameters)->value('id');

        return $id ? new static($id) : null;
    }

    /**
     * Set the restrictions for the next query
     *
     * @param  string  $column  the column name
     * @param  string  $value  the filter value
     * @return object|array|null
     */
    public static function where(array $parameters)
    {
        $rows = DB::table(static::table())->where($parameters)->pluck('id');

        if ($rows->isNotEmpty()) {
            return $rows->map(fn ($id) => new static($id))->all();
        }

        return null;
    }

    /**
     * Add a new row
     *
     * @param  array  $parameters  like ['column' => $value, ...]
     * @return int returns the ID of the inserted row
     */
    public static function add(array $parameters): int
    {
        return DB::table(static::table())->insertGetId($parameters);
    }

    /**
     * Delete all the rows matching some parameters
     */
    public static function deleteWhere(array $parameters)
    {
        return DB::table(static::table())->where($parameters)->delete();
    }

    private static function sqlWherelFields(array $parameters)
    {
        return implode(' AND ', array_map(function ($column) {
            return $column.' = ?';
        }, array_keys($parameters)));
    }

    protected static function sqlSetFields(array $parameters)
    {
        return implode(', ', array_map(function ($column) {
            return $column.' = ?';
        }, array_keys($parameters)));
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

    public static function columnExists(string $column): bool
    {
        return LaravelSchema::hasColumn(static::table(), $column);
    }

    /**
     * Alter a table
     */
    public static function alter(Closure $prepareBlueprint): void
    {
        // blue print
        $blueprint = new Blueprint;
        $prepareBlueprint($blueprint);

        // columns to add
        $addColumns = $blueprint->columns();

        array_walk($addColumns, function (&$columnQuery, $column) {
            if (! self::columnExists($column)) {
                $columnQuery = 'ADD COLUMN '.$columnQuery;
            } else {
                $columnQuery = null;
            }
        });

        // columns to drop
        $dropColumns = array_map(function ($column) {
            if (self::columnExists($column)) {
                return 'DROP COLUMN '.$column;
            } else {
                return null;
            }
        }, $blueprint->toDrop());

        $columnsQuery = (implode(', ', array_filter(condense_array($addColumns, $dropColumns))));

        DB::statement('ALTER TABLE '.static::table().' '.$columnsQuery);
    }

    /**
     * Create an instance of the item mathing the ID
     *
     * @return object | null returns the first matching item or false if no match was found
     */
    public static function find(int $id)
    {
        if (DB::table(static::table())->where('id', $id)->exists()) {
            return new static($id);
        }

        return null;
    }
    /**
     * Set the restrictions for the next query
     *
     * @param  string  $column  the column name
     * @param  string  $value  the filter value
     * @param  string  $column  the column name
     * @param  string  $value  the filter value
     * @return object
     * @return array | bool returns all the matching rows or false if no match was found

     * @return void
    private static function cleanup(): void {
        self::$where = [];
    }*/
}
