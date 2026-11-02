<?php

namespace App\View\Components\ClassDashboard\StudentResult;

use App\Helpers\SectionResultHelper;
use App\Models\Activities\Area;
use App\Models\Activities\Section as ActivitiesSection;
use App\Models\Results\User\SectionResult;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Section extends Component
{
    /**
     * Property: The result of the section
     */
    public ?string $result = null;

    /**
     * Property: Whether the section is completed
     */
    public bool $completed = false;

    /**
     * Property: The speed of the section
     */
    public ?string $speed;

    /**
     * Property: The number of attempts made to complete the self evaluation test
     */
    public ?int $evaluationAttempts = null;

    /**
     * Property: The number of attempts made to complete the other tests in the section
     */
    public array $attemptsByTest = [];

    /**
     * Property: The IDs of the reviewable tests in the section
     */
    public ?Collection $nonEvaluationTests = null;

    /**
     * Property: The IDs of the reviewable tests in the section
     */
    public array $reviewableTestIds = [];

    /**
     * Property: The information related to the section
     */
    public ?string $info = null;

    /**
     * Create a new component instance.
     */
    public function __construct(public ActivitiesSection $section, public Area $area, public Student $student)
    {
        $infoKey = 'section-infos.'.$section->originalSection()->id;

        $info = __($infoKey);

        $this->info = $info !== $infoKey ? $info : null;

        // $this->result = TestResultHelper::getResult($student->id, $section->evaluation_test_id);
        $this->result = SectionResultHelper::label($student, $section);
        $this->speed = SectionResult::where('studentId', $student->id)
            ->where('sectionId', $section->id)
            ->first()?->verboseSpeed();

        $this->completed = $student->hasCompletedSection($section);

        $tests = $section->tests;

        $testIds = $tests->pluck('id');

        if ($section->evaluation_test) {
            $testIds->push($section->evaluation_test->id);
        }

        $attemptsByTest = TestResult::completedAttemptsByTestFor($student, $testIds);

        $this->evaluationAttempts = $this->getEvaluationTestAttempts($attemptsByTest);

        $this->attemptsByTest = $attemptsByTest;

        $this->reviewableTestIds = $section
            ->reviewableTests()
            ->pluck('id')
            ->toArray();

        $this->nonEvaluationTests = $section
            ->tests
            ->where('id', '!=', $section->evaluation_test_id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.class-dashboard.student-result.section');
    }

    /**
     * Get the number of attempts made to complete the self evaluation test for the section
     */
    private function getEvaluationTestAttempts(array $attemptsByTest): ?int
    {
        $evaluationTest = $this->section->evaluation_test;

        if (! $evaluationTest) {
            return null;
        }

        $attemptTestId = $evaluationTest->dashboardAttemptTestId();

        return $attemptTestId
            ? ($attemptsByTest[$attemptTestId] ?? null)
            : null;
    }
}
