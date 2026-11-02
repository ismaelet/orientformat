<?php

namespace App\Legacy;

trait ConstructFromDatabase
{
    private $databaseEntry = [];

    public function __construct(?int $id = null)
    {
        $index = self::INDEX ?? 'id';
        $data = LegacyDB::row('* FROM '.self::TABLE.' WHERE '.$index.' = ?', [$id]);

        if ($data) {
            $this->databaseEntry = $data;
        } else {
            $columns = LegacyDB::select('COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?', [ConnectionInterface::getInstance()->database, self::TABLE]);

            while ($column = $columns->fetch_assoc()) {
                $this->databaseEntry[$column['COLUMN_NAME']] = null;
            }
        }
    }
}
