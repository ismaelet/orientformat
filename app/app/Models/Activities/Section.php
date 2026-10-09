<?php

namespace App\Models\Activities;

use App\Models\Results\User\SectionResult;
use App\Models\Results\User\TestResult;
use App\Models\Schools\Grade;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Section extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'areaId',
        'name',
        'description',
        'evaluation_test_id',
        'result_label',
        'slug',
        'estimated_duration',
        'isStandard',
        'active',
        'mainSectionId'
    ];

    /**
     * The table associated with the model
     */
    protected $table = 'sections';

    public function description(): Attribute {
        return Attribute::make(
            get: fn() => __(key: 'sections.description-' . $this->slug)
        );
    }

    /**
     * Relationship: The area that this section belongs to
     */
    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'areaId');
    }

    /**
     * Relationship: The main section that this section belongs to
     */
    public function main_section(): BelongsTo {
        return $this->belongsTo(Section::class, 'mainSectionId');
    }

    /**
     * Relationship: The grades that this section belongs to
     */
    public function grades(): BelongsToMany {
        return $this->belongsToMany(Grade::class);
    }

    /**
     * Relationship: The evaluation test for this section
     */
    public function evaluation_test(): BelongsTo {
        return $this->belongsTo(Test::class, 'evaluation_test_id');
    }

    /**
     * Relationship: The tests that belong to this section
     */
    public function tests(): HasMany {
        return $this->hasMany(Test::class, 'sectionId');
    }

    /**
     * Relationship: The active tests that belong to this section
     */
    public function active_tests(): HasMany {
        return $this->hasMany(Test::class, 'sectionId')->where('active', true);
    }

    /**
     * Get the original/main section for this section
     */
    public function originalSection(): self {
        return $this->main_section ?? $this;
    }

    /**
     * The tests that can be reviewed for this section
     */
    public function reviewableTests(): Collection {
        return $this->tests()
            ->where('id', '<>', $this->evaluation_test?->id)
            ->where('template', '<>', 'survey')
            ->where('followUpTestId', false)
            ->where('recapTestId', false)
            ->with('section')
            ->get();
    }

    /**
     * Get the first uncompleted test for the given student
     */
    public function firstUncompletedTest(Student|Teacher|null $student = null): ?Test {
        $student = $student ?? student();

        $completedTestIds = $student->test_results->pluck('testId')->toArray();

        return $this->active_tests()
            ->whereNotIn('id', $completedTestIds)
            ->orderBy('step', 'asc')
            ->first();
    }

    /**
     * Get the URL for the section
     */
    public function url(): string {
        if ($this->isCompletable()) {
            if (!student()->hasCompletedSection($this) && $this->firstUncompletedTest()) {
                return $this->firstUncompletedTest()->url();
            }

            return route('section', ['section' => $this]);
        }

        return $this->tests->first()->url();
    }

    /**
     * Check if the section is completable
     */
    public function isCompletable(): bool {
        return $this->isStandard;
    }

    /**
     * Get the count of tests in this section
     */
    public function testCount(): int {
        return $this->active_tests->count();
    }

    /**
     * Get the effective main section ID.
     */
    public function effectiveMainSectionId(): int {
        return $this->mainSectionId ?: $this->id;
    }

    /**
     * Update the progress of the section for the current student
     */
    public function updateProgress(Student|Teacher $student): void {
        $completedTestCount = $this->calcCompletedTestCount($student);
        $lastCompletedStep = $this->getLastCompletedStep();
        $percentage = round($completedTestCount / $this->testCount() * 100);
        $completed = $lastCompletedStep >= $this->active_tests->last()->step;

        SectionResult::updateOrCreate([
            'studentId' => $student->id,
            'sectionId' => $this->id,
        ], [
            'completedTestCount' => $completedTestCount,
            'lastCompletedStep' => $lastCompletedStep,
            'progressPercentage' => $percentage,
            'completed' => $completed,
        ]);

        // Update grade progress
        if (!is_teacher_or_administrator()) {
            Auth::user()->student->grade()->updateProgress();
        }
    }

    /**
     * Calculate the completed test count for the current student
     */
    private function calcCompletedTestCount(Student|Teacher $student): int {
        return TestResult::whereIn('testId', $this->active_tests->pluck('id'))
            ->where('studentId', $student->id)
            ->count();
    }

    /**
     * Get the last completed step for the section
     */
    private function getLastCompletedStep(): int {
        return TestResult::join('tests', 'results_tests.testId', '=', 'tests.id')
            ->whereIn('results_tests.testId', $this->active_tests->pluck('id'))
            ->where('results_tests.studentId', Auth::id())
            ->max('tests.step') ?? 0;
    }

    /**
     * Get the icon for the section
     * 
     * ! Legacy
     */
    public function legacyIcon(): string {
        $filePath = resource_path('svg/icons/sections/' . $this->slug . '.svg');

        if (file_exists($filePath)) {
            return embed_icon('sections/' . $this->originalSection()->slug);
        } else {
            return embed_icon('sections/section-' . $this->originalSection()->id);
        }
    }
}
