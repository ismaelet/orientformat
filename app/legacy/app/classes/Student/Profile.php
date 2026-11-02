<?php

namespace Student;

use Illuminate\Support\Facades\DB;
use System\Traits\DatabaseObject;

class Profile
{
    use DatabaseObject;

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
        DB::table(self::TABLE)->insert([self::INDEX => $id]);

        return new self($id);
    }
}
