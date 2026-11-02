<?php

namespace Legacy\Activity\Result;

use Illuminate\Support\Facades\Auth;

/**
 * GradeResult class
 */
class GradeResult
{
    use \System\Traits\DatabaseObject;

    public const TABLE = 'results_grades';

    public const INDEX = 'id';

    public const USER_INDEX = 'studentId';

    public const GRADE_INDEX = 'gradeId';

    /**
     * Get methods
     */
    private function getStudentId()
    {
        return $this->databaseEntry[self::USER_INDEX];
    }

    /**
     * Istance methods
     */
    public static function new(int $gradeId)
    {
        return \App\Legacy\LegacyDB::add(self::TABLE.' ('.self::USER_INDEX.', '.self::GRADE_INDEX.')', [Auth::id(), $gradeId]);
    }
}
