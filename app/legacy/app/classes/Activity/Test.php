<?php

namespace Legacy\Activity;

use App\Models\Activities\Survey;
use App\Models\Activities\Test as ModernTest;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\Activity\Result\AdditionalTestResult;
use Legacy\Activity\Result\Handler\StudentTestResult;
use Legacy\Activity\Result\TestResult;
use System\Traits\DatabaseObject;

/**
 * Test
 *
 * @property string title
 * @property string url
 * @property string template
 * @property string clientUrl
 * @property int sectionId
 * @property object section
 * @property int areaId
 * @property object area
 * @property int resultId
 * @property object result
 * @property bool hasResult
 * @property bool completed
 * @property bool everCompleted
 * @property int additionalResultId
 * @property object additionalResult
 * @property array additionalPrimaryResult
 * @property array additionalSecondaryResult
 * @property int nextTestId
 * @property object nextTest
 * @property bool hasNextTest
 * @property int requiredTestId
 * @property object requiredTest
 * @property bool hasRequiredTest
 * @property int followUpTestId
 * @property object followUpTest
 * @property bool hasFollowUpTest
 * @property int recapTestId
 * @property object recapTest
 * @property bool hasRecapTest
 * @property int surveyId
 * @property object survey
 */
class Test
{
    use DatabaseObject;

    public const TABLE = 'tests';

    public const INDEX = 'id';

    public const SECTION_INDEX = 'sectionId';

    public const AREA_INDEX = 'areaId';

    /**
     * Get methods
     */
    private function getStudentId()
    {
        return watchedStudentId();
    }

    private function getTitle()
    {
        return __('tests.'.$this->id);
    }

    private function getSummary()
    {
        return __('tests.summary-'.$this->id);
    }

    private function getDescription()
    {
        return __('tests.description-'.$this->id);
    }

    private function getUrl()
    {
        return '/activities/tests/'.$this->id;
    }

    private function getClientUrl()
    {
        return route('test', ['test' => $this->id]);
    }

    private function getFilePath()
    {
        return $this->area->slug.'/'.$this->section->slug.'/'.$this->slug;
    }

    private function getFullTitle()
    {
        return $this->id ? $this->section->title.' - '.$this->title : null;
    }

    private function getResultId()
    {
        return DB::table(TestResult::TABLE)->where(TestResult::USER_INDEX, $this->studentId)->where(TestResult::TEST_INDEX, $this->id)->orderByDesc('id')->value(TestResult::INDEX);
    }

    private function getResult()
    {
        return $this->hasResult ? new TestResult($this->resultId) : null;
    }

    private function getHasResult()
    {
        return (bool) $this->resultId;
    }

    private function getRawResults()
    {
        return $this->hasResult ? $this->result->rawResults : null;
    }

    private function getDetailedResult()
    {
        return (new StudentTestResult($this->id))
            ->detailedResult;
    }

    private function getCompleted()
    {
        return $this->hasResult ? $this->result->completed : false;
    }

    private function getEverCompleted()
    {
        return DB::table('results_permanent')->where('studentId', Auth::id())->where('testId', $this->id)->exists();
    }

    private function getPercentage()
    {
        return $this->result ? $this->result->percentage : 0;
    }

    private function getAdditionalResultId()
    {
        return DB::table(AdditionalTestResult::TABLE)->where(AdditionalTestResult::USER_INDEX, Auth::id())->where(AdditionalTestResult::TEST_INDEX, $this->id)->value(AdditionalTestResult::INDEX);
    }

    private function getAdditionalResult()
    {
        return $this->additionalResultId ? new AdditionalTestResult($this->additionalResultId) : null;
    }

    private function getAdditionalPrimaryResult()
    {
        return $this->additionalResult ? $this->additionalResult->primaryResults : null;
    }

    private function getAdditionalSecondaryResult()
    {
        return $this->additionalResult ? $this->additionalResult->secondaryResults : null;
    }

    private function getSection()
    {
        return new Section($this->sectionId);
    }

    private function getArea()
    {
        return $this->section->area;
    }

    private function getNextTestId()
    {
        return DB::table(self::TABLE)->where(self::SECTION_INDEX, $this->sectionId)->where('step', '>', $this->step)->where('active', 1)->orderBy('step')->value(self::INDEX);
    }

    private function getNextTest()
    {
        return $this->hasNextTest ? new Test($this->nextTestId) : null;
    }

    private function getHasNextTest()
    {
        return (bool) $this->nextTestId;
    }

    private function getRequiredTest()
    {
        return new Test($this->requiredTestId);
    }

    private function getHasRequiredTest()
    {
        return (bool) $this->requiredTestId;
    }

    private function getFollowUpTestId()
    {
        return $this->databaseEntry['followUpTestId'] ?: DB::table(self::TABLE)->where('requiredTestId', $this->id)->value(self::INDEX);
    }

    private function getFollowUpTest()
    {
        return new Test($this->followUpTestId);
    }

    private function getHasFollowUpTest()
    {
        return (bool) $this->followUpTestId;
    }

    private function getRecapTest()
    {
        return new Test($this->recapTestId);
    }

    private function getHasRecapTest()
    {
        return (bool) $this->recapTestId;
    }

    private function getSurvey()
    {
        return Survey::find($this->surveyId);
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
     * Misc methods
     */
    // save the test result
    public function saveResult($results, $percentage, $completed, $speed)
    {
        TestResult::new([
            'studentId' => Auth::id(),
            'testId' => $this->id,
            'results' => $results,
            'percentage' => $percentage,
            'completed' => $completed,
            'speed' => $speed,
        ]);

        // update section progress
        $this->section->updateProgress();
    }

    // advance to the next test
    public function advanceUrl(
        Student|Teacher $student,
        bool $reloadPage = false
    ): string {
        $test = ModernTest::findOrFail($this->id);

        if ($reloadPage) {
            return $test->url();
        }

        return $test->nextUrl($student);
    }

    public function redo(): void
    {
        DB::table(TestResult::TABLE)->where(TestResult::USER_INDEX, Auth::id())->where(TestResult::TEST_INDEX, $this->id)->delete();

        DB::table(AdditionalTestResult::TABLE)->where(AdditionalTestResult::USER_INDEX, Auth::id())->where(AdditionalTestResult::TEST_INDEX, $this->id)->delete();

        DB::table('results_others')->where('userID', userId())->where('testID', $this->id)->delete();

        $this->section->updateProgress();
    }

    public function newTest(): ModernTest
    {
        return ModernTest::find($this->id);
    }
}
