<?php

namespace Legacy\UserSystem;

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
        if (\App\Legacy\LegacyDB::exists(Teacher::TABLE.' WHERE '.Teacher::INDEX.' = ?', [userId()])) {
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
