<?php

namespace Legacy\UserSystem;

use App\Legacy\LegacyDB;
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
        if (LegacyDB::exists(Student::TABLE.' WHERE '.Student::INDEX.' = ?', [userId()])) {
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
