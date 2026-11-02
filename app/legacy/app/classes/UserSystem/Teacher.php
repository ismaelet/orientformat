<?php

namespace Legacy\UserSystem;

use App\Legacy\User;
use Illuminate\Support\Facades\DB;
use Legacy\SchoolSystem\SchoolClass;
use System\Traits\DatabaseObject;

/**
 * Teacher class
 *
 * @property array schoolClassIds
 * @property array schoolClasses
 */
class Teacher
{
    use DatabaseObject;

    const TABLE = 'teachers';

    const INDEX = 'userId';

    private function getId()
    {
        return $this->databaseEntry[self::INDEX];
    }

    private function getFullName()
    {
        return $this->user->fullName;
    }

    private function getInvertedFullName()
    {
        return $this->user->fullNameInv;
    }

    private function getUser()
    {
        return new User($this->id);
    }

    private function getStudentIdsString()
    {
        return $this->studentIds ? implode(',', $this->studentIds) : false;
    }

    private function getSchoolClassIds(string $type = 'all')
    {
        $results = [];

        if ($this->id && $this->databaseEntry['classes']) {
            switch ($type) {
                default:
                    $results = DB::table(SchoolClass::TABLE)
                        ->whereRaw('FIND_IN_SET('.SchoolClass::INDEX.', ?)', [$this->databaseEntry['classes']])
                        ->orderByDesc('year')
                        ->orderByDesc('grade')
                        ->pluck(SchoolClass::INDEX)
                        ->all() ?: null;
            }
        }

        return $results;
    }

    public function getSchoolClasses(string $type = 'all')
    {
        $schoolClasses = false;

        if ($this->schoolClassIds) {
            $schoolClasses = [];

            foreach ($this->schoolClassIds as $schoolClassId) {
                if (! empty($schoolClassId) && DB::table(SchoolClass::TABLE)->where(SchoolClass::INDEX, $schoolClassId)->exists()) {
                    $schoolClasses[] = new SchoolClass($schoolClassId);
                }
            }
        }

        return $schoolClasses;
    }

    private function getSchoolClassCount()
    {
        return $this->schoolClasses ? count($this->schoolClasses) : 0;
    }

    private function getStudentIds()
    {
        $studentIds = false;

        if ($this->schoolClassIds) {
            $schoolClassIdsString = implode(',', $this->schoolClassIds);
            $studentIds = DB::table(Student::TABLE)
                ->whereRaw('FIND_IN_SET('.Student::SCHOOL_CLASS_INDEX.', ?)', [$schoolClassIdsString])
                ->pluck(Student::INDEX)
                ->all() ?: null;
        }

        return $studentIds;
    }
}
