<?php

namespace Legacy\SchoolSystem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\Activity\Area;
use Legacy\Activity\Result\GradeResult;
use Legacy\Activity\Result\TestResult;
use Legacy\Activity\Section;
use Legacy\Activity\Test;
use System\Traits\DynamicProperties;

/**
 * Grade class
 *
 * @property string name
 * @property string romanNumeral
 * @property string adjective
 * @property string relativeId
 * @property string fullId
 * @property bool isMiddleSchool
 * @property bool isHighSchool
 * @property array standardTestIds
 * @property int standardTestCount
 * @property array sections
 * @property array doableSectionIds
 * @property string doableSectionIdsString
 * @property array doableSections
 * @property int doableSectionCount
 * @property int progressPercentage
 */
class Grade
{
    use DynamicProperties;

    private const NAMES = ['Prima', 'Seconda', 'Terza', 'Quarta', 'Quinta'];

    private const ROMAN_NUMERALS = ['I', 'II', 'III', 'IV', 'V'];

    private const ADJECTIVES = ['first', 'second', 'third', 'fourth', 'fifth'];

    public $id = null;

    private $schoolClass = null;

    public function __construct(int $gradeNumber, ?object $schoolClass = null)
    {
        $this->id = $gradeNumber;
        $this->schoolClass = $schoolClass ?: (is_teacher_or_administrator() ? 0 : new SchoolClass(Auth::user()->student->class->id));
    }

    /*
    * Get methods
    */
    private function getRelativeId()
    {
        return $this->isMiddleSchool ? $this->id : $this->id - 3;
    }

    private function getFullId()
    {
        $professionalSchoolClass = $this->isProfessional;

        return $this->id > 5 ? ($professionalSchoolClass ? $this->id.'P' : $this->id.'L') : $this->id;
    }

    private function getIsMiddleSchool()
    {
        return $this->id <= 3;
    }

    private function getIsProfessional()
    {
        return $this->schoolClass->isProfessional;
    }

    private function getIsHighSchool()
    {
        return ! $this->isMiddleSchool;
    }

    private function getName()
    {
        return self::NAMES[$this->relativeId - 1];
    }

    private function getRomanNumeral()
    {
        return self::ROMAN_NUMERALS[$this->relativeId - 1];
    }

    private function getAdjective()
    {
        return __(self::ADJECTIVES[$this->relativeId - 1]);
    }

    private function getAreas()
    {
        return rows_to_objects(DB::table(Area::TABLE)
            ->select(Area::INDEX)
            ->whereIn('id', DB::table('sections')->select(Section::AREA_INDEX)->whereRaw('FIND_IN_SET(?, years)', [$this->fullId]))
            ->get(), Area::class);
    }

    private function getSections()
    {
        return rows_to_objects(DB::table('sections')->select(Section::INDEX)->whereRaw('FIND_IN_SET(?, years)', [$this->fullId])->where('active', 1)->get(), Section::class);
    }

    private function getDoableSections()
    {
        return rows_to_objects(DB::table('sections')->select(Section::INDEX)->whereRaw('FIND_IN_SET(?, years)', [$this->fullId])->where('active', 1)->where('isStandard', 1)->get(), Section::class);
    }

    private function getDoableSectionIds()
    {
        $sectionIds = [];

        foreach ($this->doableSections as $legacySection) {
            $sectionIds[] = $legacySection->id;
        }

        return $sectionIds;
    }

    private function getDoableSectionIdsString()
    {
        return implode(',', $this->doableSectionIds);
    }

    private function getDoableSectionCount()
    {
        return count($this->doableSections);
    }

    private function getResultId()
    {
        $resultId = DB::table(GradeResult::TABLE)->where(GradeResult::GRADE_INDEX, $this->id)->where(GradeResult::USER_INDEX, Auth::id())->value(GradeResult::INDEX);

        if (! $resultId) {
            $resultId = GradeResult::new($this->id);
            $this->updateProgress();
        }

        return $resultId;
    }

    private function getResult()
    {
        return $this->resultId ? new GradeResult($this->resultId) : null;
    }

    private function getProgressPercentage()
    {
        return $this->result ? $this->result->progressPercentage : 0;
    }

    private function getStandardTestIds()
    {
        return DB::table(Test::TABLE)
            ->join(Section::TABLE, Test::TABLE.'.'.Test::SECTION_INDEX, '=', Section::TABLE.'.'.Section::INDEX)
            ->where('isStandard', 1)
            ->where(Test::TABLE.'.active', 1)
            ->where(Section::TABLE.'.active', 1)
            ->whereRaw('FIND_IN_SET(?, years)', [$this->fullId])
            ->pluck(Test::TABLE.'.'.Test::INDEX)
            ->all();
    }

    private function getStandardTestCount()
    {
        return count($this->standardTestIds);
    }

    /**
     * Set methods
     */
    public function setIsProfessional(bool $isProfessional)
    {
        $this->data['isProfessional'] = $isProfessional;

        unset($this->data['fullId']);

        return $this;
    }

    /**
     * Update methods
     */
    public function updateProgress()
    {
        $progressPercentage = $this->calcProgress();

        DB::table(GradeResult::TABLE)->where(GradeResult::GRADE_INDEX, $this->id)->where(GradeResult::USER_INDEX, Auth::id())->update(['progressPercentage' => $progressPercentage]);
    }

    /**
     * Calc methods
     */
    private function calcProgress()
    {
        $legacyTestCount = $this->standardTestCount;

        $completedTestCount = DB::table(TestResult::TABLE)
            ->where(TestResult::USER_INDEX, Auth::id())
            ->where('completed', 1)
            ->whereIn(TestResult::TEST_INDEX, $this->standardTestIds)
            ->count();

        return round($completedTestCount / $legacyTestCount * 100);
    }
}
