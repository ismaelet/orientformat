<?php

namespace Student;

class Profile
{
    use \System\Traits\DatabaseObject;

    public const TABLE = 'students_data';

    public const INDEX = 'studentId';

    /**
     * Get methods
     */

    /**
     * Istance methods
     */
    public static function new(int $id)
    {
        \App\Legacy\LegacyDB::add(self::TABLE.' ('.self::INDEX.')', [$id]);

        return new self($id);
    }
}
