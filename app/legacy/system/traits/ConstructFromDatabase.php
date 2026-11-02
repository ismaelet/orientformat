<?php

namespace System\Traits;

use Illuminate\Support\Facades\DB;

trait ConstructFromDatabase
{
    private $databaseEntry = [];

    public function __construct(?int $id = null)
    {
        $index = self::INDEX ?? 'id';
        $data = (array) DB::table(self::TABLE)->where($index, $id)->first();

        if ($data) {
            $this->databaseEntry = $data;
        } else {
            $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
                ->where('TABLE_SCHEMA', DB::getDatabaseName())
                ->where('TABLE_NAME', self::TABLE)
                ->pluck('COLUMN_NAME');

            foreach ($columns as $column) {
                $this->databaseEntry[$column] = null;
            }
        }
    }
}
