<?php

namespace Legacy\UserSystem;

use Illuminate\Support\Facades\DB;
use System\Traits\Singleton;

class ActiveTeacher
{
    use Singleton;

    private static $id;

    private static $teacher;

    /**
     * Magic methods
     */
    private function __construct()
    {
        if (DB::table(Teacher::TABLE)->where(Teacher::INDEX, userId())->exists()) {
            $teacher = new Teacher(userId());

            self::$id = $teacher->id;
            self::$teacher = new Teacher(self::$id);
        }
    }

    public function __get($property)
    {
        return self::$id ? self::$teacher->$property : null;
    }

    public function getSchoolClasses(string $type = 'all')
    {
        self::$teacher->getSchoolClasses($type);
    }
}
