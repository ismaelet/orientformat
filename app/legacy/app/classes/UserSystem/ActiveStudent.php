<?php

namespace Legacy\UserSystem;

use Illuminate\Support\Facades\DB;
use System\Traits\Singleton;

class ActiveStudent
{
    use Singleton;

    private static $id;

    private static $student;

    /**
     * Magic methods
     */
    private function __construct()
    {
        if (DB::table(Student::TABLE)->where(Student::INDEX, userId())->exists()) {
            $student = new Student(userId());

            self::$id = $student->id;
            self::$student = new Student(self::$id);
        }
    }

    public function __get($property)
    {
        return self::$id ? self::$student->$property : null;
    }
}
