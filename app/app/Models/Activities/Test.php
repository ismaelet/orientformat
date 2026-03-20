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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Test extends Model {

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
    protected function name(): Attribute {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.' . $this->section->slug . '-' . $this->slug);

                if ($name !== 'tests.' . $this->section->slug . '-' . $this->slug) {
                    return $name;
                }

                // Legacy fallback
                $name = __('tests.' . $this->id);

                if ($name !== 'tests.' . $this->id) {
                    return $name;
                }

                return $this->title;
            }
        );
    }

    /**
     * Attribute: The summary of the test
     */
    protected function summary(): Attribute {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.summary-' . $this->section->slug . '-' . $this->slug);

                if ($name !== 'tests.summary-' . $this->section->slug . '-' . $this->slug) {
                    return $name;
                }

                // Legacy fallback
                return __('tests.summary-' . $this->id);
            }
        );
    }

    /**
     * Attribute: The summary of the test
     */
    protected function description(): Attribute {
        return Attribute::make(
            get: function (): string {
                $name = __('tests.description-' . $this->section->slug . '-' . $this->slug);

                if ($name !== 'tests.description-' . $this->section->slug . '-' . $this->slug) {
                    return $name;
                }

                // Legacy fallback
                return __('tests.description-' . $this->id);
            }
        );
    }

    /**
     * Relationship: The section that owns the test
     */
    public function section(): BelongsTo {
        return $this->belongsTo(Section::class, 'sectionId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function required_tests(): HasMany {
        return $this->hasMany(Test::class, 'recapTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function previous_tests(): HasMany {
        return $this->hasMany(Test::class, 'followUpTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function required_test(): BelongsTo {
        return $this->belongsTo(Test::class, 'requiredTestId');
    }

    /**
     * Relationship: The tests that are required by this test
     */
    public function dependent_tests(): Collection {
        $requiredTests = $this->required_tests()->get() ?? collect();
        $previousTests = $this->previous_tests()->get() ?? collect();
        $requiredTest = $this->required_test()->first();
        $requiredTestCollection = $requiredTest ? collect([$requiredTest]) : collect();

        return $requiredTests->merge($previousTests)->merge($requiredTestCollection);
    }

    /**
     * Get the next test in the sequence
     */
    public function nextTest(): ?Test {
        return self::where('sectionId', $this->sectionId)
            ->where('step', '>', $this->step)
            ->where('active', true)
            ->orderBy('step', 'asc')
            ->first();
    }

    /**
     * Get the URL for the test
     */
    public function url(?int $studentId = null, ?string $from = null): string {
        return route('test', ['test' => $this, 'student_id' => $studentId, 'from' => $from]);
    }

    /**
     * Get the view name for the test
     */
    public function view(): string {
        return $this->section->isCompletable() ? 'tests.' . $this->section->slug . '.' . $this->slug : 'tests.' . $this->section->slug;
    }

    /**
     * Get the helper class for the test
     */
    public function helper(): ?object {
        $className = $this->section->isCompletable() ? $this->section->slug . '-' . $this->slug : $this->section->slug;
        $className = "App\\Helpers\\Tests\\" . ucfirst(str()->camel($className)) . 'Helper';

        if (class_exists($className)) {
            return new $className();
        }

        return null;
    }

    /**
     * Store the result of the test
     */
    public function storeResult(Student|Teacher $student, array $fields, int $timePassed): void {
        TestResult::updateOrCreate([
            'studentId' => $student->id,
            'testId' => $this->id,
        ], [
            'result' => implode(',', $fields),
            'percentage' => $this->calcPercentage($fields),
            'completed' => true,
            'speed' => $timePassed,
        ]);

        // update section progress
        $this->section->updateProgress($student);
    }

    /**
     * Calculate the percentage of correct answers based on the provided fields
     */
    private function calcPercentage(array $fields): int {
        if ($this->helper()) {
            return $this->helper()->calculatePercentage($fields);
        }

        return 100;
    }

    /**
     * Get the next URL after completing the test
     */
    public function nextUrl(Student|Teacher $student): string {
        return match (true) {
            // If the test requires review, reload the same test
            $this->reviewResult => $this->url(),

            // If the student has completed the section, go to the section URL
            $student->hasCompletedSection($this->section) => $this->section->url(),

            // Default: go to the next test or section URL 
            default => $this->nextTest()?->url() ?? $this->section->url(),
        };
    }

    /**
     * Get the file path for the test
     * 
     * ! Legacy
     */
    public function filePath(): string {
        return $this->section->area->slug . '/' . $this->section->slug . '/' . $this->slug;
    }
}
