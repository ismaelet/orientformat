<?php

namespace Legacy\Activity\Result;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use System\Traits\DatabaseObject;

/**
 * GradeResult class
 */
class GradeResult
{
    use DatabaseObject;

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
        return DB::table(self::TABLE)->insertGetId([self::USER_INDEX => Auth::id(), self::GRADE_INDEX => $gradeId]);
    }
}
