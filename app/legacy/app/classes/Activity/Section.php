<?php

namespace Legacy\Activity;

use App\Legacy\User;
use App\Models\Activities\Section as ActivitiesSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\Activity\Result\SectionResult;
use Legacy\Activity\Result\TestResult;
use LegacyModels\Activities\Results\CondensedSectionResult;
use LegacyModels\Activities\Section as SectionModel;
use System\Traits\DatabaseObject;

/**
 * Section class
 *
 * @property string name
 * @property string slug
 * @property string filePath
 * @property string url
 * @property string clientUrl
 * @property int lastStep
 * @property array tests
 * @property int testCount
 * @property int completedTestCount
 * @property int resultId
 * @property object result
 * @property int lastCompletedStep
 * @property int progressPercentage
 * @property bool completed
 * @property int mainSectionId
 * @property object mainSection
 * @property bool isMainSection
 */
class Section
{
    use DatabaseObject;

    public const TABLE = 'sections';

    public const INDEX = 'id';

    public const AREA_INDEX = 'areaId';

    /*
    * Get methods
    */
    private function getStudentId()
    {
        return Auth::id();
    }

    private function getName()
    {
        return __('sections.'.$this->slug);
    }

    private function getDescription()
    {
        return __('sections.description-'.$this->slug);
    }

    private function getTitle()
    {
        return $this->getName();
    }

    private function getUrl()
    {
        return $this->newSection()->url();
    }

    private function getClientUrl()
    {
        return $this->newSection()->url();
    }

    private function getFilePath()
    {
        return $this->area->slug.'/'.$this->slug;
    }

    private function getIcon()
    {
        return '/sections/section-'.$this->mainSectionId;
    }

    private function getArea()
    {
        return new Area($this->areaId);
    }

    private function getTests()
    {
        return rows_to_objects(DB::table(Test::TABLE)->select(Test::INDEX)->where(Test::SECTION_INDEX, $this->id)->where('active', 1)->get(), Test::class);
    }

    private function getTestCount()
    {
        return count($this->tests);
    }

    private function getLastStep()
    {
        return DB::table(Test::TABLE)->where(Test::SECTION_INDEX, $this->id)->where('active', 1)->max('step');
    }

    private function getLastCompletedStep()
    {
        return $this->result ? $this->result->lastCompletedStep : 0;
    }

    private function getResultId()
    {
        $resultId = DB::table(SectionResult::TABLE)->where('sectionId', $this->id)->where('studentId', $this->studentId)->value(SectionResult::INDEX);

        return $resultId ?: (SectionResult::new($this->id))->id;
    }

    private function getResult()
    {
        return $this->resultId ? new SectionResult($this->resultId) : null;
    }

    private function getCheckpointId()
    {
        return DB::table(Test::TABLE)->where('active', 1)->where(Test::SECTION_INDEX, $this->id)
            ->whereNotIn(Test::INDEX, DB::table(TestResult::TABLE)->select(TestResult::TEST_INDEX)->where(TestResult::USER_INDEX, $this->studentId))
            ->orderBy('step')->value(Test::INDEX);
    }

    private function getCheckpoint()
    {
        return new Test($this->checkpointId);
    }

    private function getCompletedTestCount()
    {
        return $this->result ? $this->result->completedTestCount : 0;
    }

    public function getProgressPercentage()
    {
        if ($this->isStandard) {
            return (int) DB::table('results_sections')->where('studentId', Auth::id())->where('sectionId', $this->id)->value('progressPercentage');
        } else {
            return 100;
        }
    }

    public function getCompleted()
    {
        if ($this->isStandard) {
            return DB::table('results_sections')->where('studentId', $this->studentId)->where('sectionId', $this->id)->where('completed', 1)->exists();
        } else {
            return true;
        }
    }

    private function getMainSectionId()
    {
        return $this->databaseEntry['mainSectionId'] ?: $this->id;
    }

    private function getMainSection()
    {
        return $this->databaseEntry['mainSectionId'] ? new self($this->mainSectionId) : $this;
    }

    private function getIsMainSection()
    {
        return $this->mainSectionId == $this->id;
    }

    /**
     * Set methods
     */
    public function setStudentId(int $studentId)
    {
        $this->data['studentId'] = $studentId;

        return $this;
    }

    /**
     * Update methods
     */
    public function updateProgress()
    {
        if (! $this->resultId) {
            SectionResult::new($this->id);
        }

        // update section progress
        $completedTestCount = $this->calcCompletedTestCount();
        $lastCompletedStep = $this->calcLastCompletedStep();
        $percentage = round($completedTestCount / $this->testCount * 100);
        $completed = $lastCompletedStep >= $this->lastStep ? 1 : 0;

        DB::table(SectionResult::TABLE)->where('studentId', Auth::id())->where('sectionId', $this->id)->update([
            'completedTestCount' => $completedTestCount,
            'lastCompletedStep' => $lastCompletedStep,
            'progressPercentage' => $percentage,
            'completed' => $completed,
        ]);

        DB::table(CondensedSectionResult::table())->where(CondensedSectionResult::linkedIndexName(User::class), Auth::id())->where(CondensedSectionResult::linkedIndexName(SectionModel::class), $this->id)->delete();

        // update grade progress
        if (! is_teacher_or_administrator()) {
            Auth::user()->student->grade()->updateProgress();
        }

        // return this
        $this->resetDynamicProperties();

        return $this;
    }

    /**
     * Calc methods
     */
    private function calcCompletedTestCount()
    {
        return DB::table(TestResult::TABLE)
            ->join(Test::TABLE, TestResult::TABLE.'.'.TestResult::TEST_INDEX, '=', Test::TABLE.'.'.Test::INDEX)
            ->where(Test::TABLE.'.'.Test::SECTION_INDEX, $this->id)
            ->where(Test::TABLE.'.active', 1)
            ->where(TestResult::TABLE.'.'.TestResult::USER_INDEX, Auth::id())
            ->count();
    }

    private function calcLastCompletedStep()
    {
        return DB::table(TestResult::TABLE)
            ->join(Test::TABLE, TestResult::TABLE.'.'.TestResult::TEST_INDEX, '=', Test::TABLE.'.'.Test::INDEX)
            ->where(Test::TABLE.'.'.Test::SECTION_INDEX, $this->id)
            ->where(Test::TABLE.'.active', 1)
            ->where(TestResult::TABLE.'.'.TestResult::USER_INDEX, Auth::id())
            ->max('step');
    }

    public function newSection(): ?ActivitiesSection
    {
        return ActivitiesSection::find($this->id);
    }
}
