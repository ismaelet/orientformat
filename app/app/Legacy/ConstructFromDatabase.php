<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait ConstructFromDatabase
{
    private $databaseEntry = [];

    public function __construct(?int $id = null)
    {
        $index = self::INDEX ?? 'id';
        $data = DB::table(self::TABLE)->where($index, $id)->first();

        if ($data) {
            $this->databaseEntry = (array) $data;
        } else {
            foreach (Schema::getColumnListing(self::TABLE) as $column) {
                $this->databaseEntry[$column] = null;
            }
        }
    }
}
