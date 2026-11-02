<?php

namespace App\Models\Activities;

use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Test extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model
     */
    protected $table = 'tests';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'sectionId',
        'areaId',
        'title',
        'description',
        'shortDescription',
        'slug',
        'step',
        'template',
        'reviewable',
        'reviewResult',
    ];

    protected $casts = [
        'reviewable' => 'boolean',
        'reviewResult' => 'boolean',
    ];

    /**
     * Attribute: The name of the test
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.'.$this->section->slug.'-'.$this->slug);

                if ($name !== 'tests.'.$this->section->slug.'-'.$this->slug) {
                    return $name;
                }

                // Legacy fallback
                $name = __('tests.'.$this->id);

                if ($name !== 'tests.'.$this->id) {
                    return $name;
                }

                return $this->title;
            }
        );
    }

    /**
     * Attribute: The slug of the test with the ID to ensure uniqueness
     */
    protected function slugWithId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->id.'-'.str()->slug($this->name)
        );
    }

    /**
     * Attribute: The summary of the test
     */
    protected function summary(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.summary-'.$this->section->slug.'-'.$this->slug);

                if ($name !== 'tests.summary-'.$this->section->slug.'-'.$this->slug) {
                    return $name;
                }

                // Legacy fallback
                return __('tests.summary-'.$this->id);
            }
        );
    }

    /**
     * Attribute: The description of the test
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.description-'.$this->section->slug.'-'.$this->slug);

                if ($name !== 'tests.description-'.$this->section->slug.'-'.$this->slug) {
                    return $name;
                }

                // Legacy fallback
                return __('tests.description-'.$this->id);
            }
        );
    }

    /**
     * Use the slug with ID for route model binding to ensure uniqueness
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        $id = explode('-', $value, 2)[0];

        if (! ctype_digit($id)) {
            return null;
        }

        return $this->newQuery()->findOrFail($id);
    }

    /**
     * Relationship: The section that owns the test
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'sectionId');
    }

    /**
     * Relationship: The survey that owns the test
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'surveyId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function required_tests(): HasMany
    {
        return $this->hasMany(Test::class, 'recapTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function previous_tests(): HasMany
    {
        return $this->hasMany(Test::class, 'followUpTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function required_test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'requiredTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function dependent_tests(): Collection
    {
        $requiredTests = $this->required_tests()->get() ?? collect();
        $previousTests = $this->previous_tests()->get() ?? collect();
        $requiredTest = $this->required_test()->first();
        $requiredTestCollection = $requiredTest ? collect([$requiredTest]) : collect();

        return $requiredTests->merge($previousTests)->merge($requiredTestCollection);
    }

    /**
     * Get the next test in the sequence
     */
    public function nextTest(): ?Test
    {
        return self::where('sectionId', $this->sectionId)
            ->where('step', '>', $this->step)
            ->where('active', true)
            ->orderBy('step', 'asc')
            ->first();
    }

    /**
     * Get the URL for the test
     */
    public function url(?int $studentId = null, ?string $from = null): string
    {
        return route('test', ['test' => $this->slug_with_id, 'student_id' => $studentId, 'from' => $from]);
    }

    /**
     * Get the view name for the test
     */
    public function view(): string
    {
        if ($this->template == 'survey') {
            return 'tests.survey';
        }

        if ($this->section->isCompletable()) {
            return 'tests.'.$this->section->slug.'.'.$this->slug;
        }

        return 'tests.'.$this->section->slug;
    }

    /**
     * Get the helper class for the test
     */
    public function helperClass(): string
    {
        $className = $this->section->isCompletable() ? $this->section->slug.'-'.$this->slug : $this->section->slug;
        $className = 'App\\Helpers\\Tests\\'.ucfirst(str()->camel($className)).'Helper';

        return $className;
    }

    /**
     * Get the helper instance for the test if the class exists
     */
    public function helper(): ?object
    {
        if (class_exists($this->helperClass())) {
            $className = $this->helperClass();

            return new $className;
        }

        return null;
    }

    /**
     * Store the result of the test
     */
    public function storeResult(Student|Teacher $student, array $fields, int $timePassed, Request $request): void
    {
        TestResult::create([
            'studentId' => $student->id,
            'testId' => $this->id,
            'result' => implode(',', $fields),
            'percentage' => $this->calcPercentage($fields),
            'completed' => true,
            'speed' => $timePassed,
        ]);

        // Store additional result if the helper defines it
        $this->storeAdditionalResult($request);

        // Update section progress
        $this->section->updateProgress($student);
    }

    /**
     * Calculate the percentage of correct answers based on the provided fields
     */
    private function calcPercentage(array $fields): int
    {
        if ($this->helper()) {
            return $this->helper()->calculatePercentage($fields);
        }

        if ($this->template === 'survey') {
            return $this->calcSurveyPercentage($fields);
        }

        return 100;
    }

    /**
     * Calculate the percentage for survey tests based on the provided fields
     */
    private function calcSurveyPercentage(array $fields): int
    {
        $survey = $this->survey;
        $total = 0;
        $result = [];

        // get results
        $max = $survey->questionCount() * ($survey->answerCount() - 1);

        foreach ($fields as $value) {
            $result[] = $value;
            $total += $value;
        }

        $result = implode(',', $result);

        // get the score
        return round($total / $max * 100);
    }

    /**
     * Store additional result if the helper defines the method
     */
    private function storeAdditionalResult(Request $request): void
    {
        if ($this->helper() && method_exists($this->helper(), 'storeAdditionalResult')) {
            $this->helper()->storeAdditionalResult($request);
        }
    }

    /**
     * Get the next URL after completing the test
     */
    public function nextUrl(Student|Teacher $student): string
    {
        return match (true) {
            // If the test requires review, reload the same test
            $this->reviewResult => $this->url(),

            // If the test is a survey, go to the next test
            $this->template === 'survey' => $this->nextTest()?->url(),

            // If the student has completed the section, go to the section URL
            $student->hasCompletedSection($this->section) => $this->section->url(),

            // Default: go to the next test or section URL
            default => $this->nextTest()?->url() ?? $this->section->url(),
        };
    }

    /**
     * Count how many times this test was completed by a student.
     */
    public function completedAttemptsFor(Student|int $student): int
    {
        $studentId = $student instanceof Student ? $student->id : $student;

        return TestResult::where('studentId', $studentId)
            ->where('testId', $this->id)
            ->where('completed', true)
            ->count();
    }

    /**
     * Get the test ID that should be used to display dashboard attempts.
     */
    public function dashboardAttemptTestId(): ?int
    {
        // If this evaluation test has one direct required test,
        // use the required test attempts instead.
        if ($this->required_test) {
            return $this->required_test->id;
        }

        // If this evaluation test summarizes multiple tests,
        // do not display a single attempt count.
        if (
            $this->required_tests->isNotEmpty() ||
            $this->previous_tests->isNotEmpty()
        ) {
            return null;
        }

        // Otherwise, use the evaluation test itself.
        return $this->id;
    }

    /**
     * Get the file path for the test
     *
     * ! Legacy
     */
    public function filePath(): string
    {
        return $this->section->area->slug.'/'.$this->section->slug.'/'.$this->slug;
    }
}
