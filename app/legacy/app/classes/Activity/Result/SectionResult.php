<?php

namespace Legacy\Activity\Result;

use App\Legacy\LegacyDB;
use Illuminate\Support\Facades\Auth;
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
        return LegacyDB::sum('speed FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ?'.' AND '.TestResult::TEST_INDEX.' IN (SELECT '.Test::INDEX.' FROM '.Test::TABLE.' WHERE '.Test::SECTION_INDEX.' = ?)', [$this->studentId, $this->sectionId]);
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
        LegacyDB::update(self::TABLE.' SET completed = ? WHERE '.self::INDEX.' = ?', [$completed ? 1 : 0, $this->id]);

        $this->data['completed'] = $completed;

        return $this;
    }

    /**
     * Istance methods
     */
    public static function new($sectionId)
    {
        $id = LegacyDB::add(self::TABLE.' ('.self::USER_INDEX.', '.self::SECTION_INDEX.')', [Auth::id(), $sectionId]);

        return new self($id);
    }
}
