<?php

namespace Legacy\Activity\Result;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\Activity\Result\Handler\StudentSectionResult;
use Legacy\Activity\Test;
use System\Traits\DatabaseObject;

class SectionResult
{
    use DatabaseObject;

    public const TABLE = 'results_sections';

    public const INDEX = 'id';

    public const USER_INDEX = 'studentId';

    public const SECTION_INDEX = 'sectionId';

    /**
     * Get methods
     */
    private function getStudentId()
    {
        return $this->databaseEntry[self::USER_INDEX];
    }

    private function getCondensedStudentResult()
    {
        return (new StudentSectionResult($this->{self::SECTION_INDEX}, $this->{self::USER_INDEX}))->result;
    }

    private function getSpeed()
    {
        return DB::table(TestResult::TABLE)
            ->where(TestResult::USER_INDEX, $this->studentId)
            ->whereIn(TestResult::TEST_INDEX, DB::table(Test::TABLE)->select(Test::INDEX)->where(Test::SECTION_INDEX, $this->sectionId))
            ->sum('speed');
    }

    private function getSpeedString()
    {
        $speedString = null;

        if ($this->speed >= 60) {
            $minutes = round($this->speed / 60);

            $speedString = $minutes;
            $speedString .= $minutes == 1 ? ' minuto' : ' minuti';
        } elseif ($this->speed) {
            $seconds = $this->speed;

            $speedString = $seconds;
            $speedString .= $seconds == 1 ? ' secondo' : ' secondi';
        }

        return $speedString;
    }

    /**
     * Update methods
     */
    public function updateCompleted(bool $completed)
    {
        DB::table(self::TABLE)->where(self::INDEX, $this->id)->update(['completed' => $completed ? 1 : 0]);

        $this->data['completed'] = $completed;

        return $this;
    }

    /**
     * Istance methods
     */
    public static function new($sectionId)
    {
        $id = DB::table(self::TABLE)->insertGetId([self::USER_INDEX => Auth::id(), self::SECTION_INDEX => $sectionId]);

        return new self($id);
    }
}
