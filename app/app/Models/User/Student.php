<?php

namespace App\Models\User;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\AdditionalResult;
use App\Models\Results\User\CondensedSectionResult;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\OtherResult;
use App\Models\Results\User\PermanentResult;
use App\Models\Results\User\SectionResult;
use App\Models\Results\User\TestResult;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Models\Student\Advice;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'userId',
        'id',
        'schoolClassId',
        'created_at',
    ];

    /**
     * Get the student's username
     */
    public function username(): Attribute {
        return new Attribute(
            get: fn(): string => $this->user?->username ?: '-',
        );
    }

    /**
     * Get the student's first name
     */
    public function firstName(): Attribute {
        return new Attribute(
            get: fn() => $this->user->first_name,
        );
    }

    /**
     * Get the student's last name
     */
    public function lastName(): Attribute {
        return new Attribute(
            get: fn() => $this->user->last_name,
        );
    }

    /**
     * Get the student's inverted full name
     */
    public function fullName(): Attribute {
        return new Attribute(
            get: fn(): string => $this->user?->full_name ?: '-',
        );
    }

    /**
     * Get the student's inverted full name
     */
    public function invertedFullName(): Attribute {
        return new Attribute(
            get: fn() => $this->user?->inverted_full_name
                ?: '-',
        );
    }

    /**
     * Get the student's registration date
     */
    public function createdAtDate(): Attribute {
        return new Attribute(
            get: fn(): string => $this->user?->created_at->format('d/m/Y') ?: '-',
        );
    }

    /**
     * The user linked to the student
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * The class the student is in
     */
    public function class(): BelongsTo {
        return $this->belongsTo(SchoolClass::class, 'schoolClassId');
    }

    /**
     * The class the student is in
     * 
     * ! Legacy
     */
    public function school_class(): BelongsTo {
        return $this->belongsTo(SchoolClass::class, 'schoolClassId');
    }

    /**
     * Get the student's given advice
     */
    public function advice(): HasOne {
        return $this->hasOne(Advice::class, 'userID', 'userId');
    }

    /**
     * Relationship: The test results of the student
     */
    public function test_results(): HasMany {
        return $this->hasMany(TestResult::class, 'studentId');
    }

    /**
     * Relationship: The section results of the student
     */
    public function section_results(): HasMany {
        return $this->hasMany(SectionResult::class, 'studentId');
    }

    /**
     * The condensed section results of the student
     */
    public function condensed_section_results(): HasMany {
        return $this->hasMany(CondensedSectionResult::class, 'student_id');
    }

    /**
     * The grade results of the student
     */
    public function grade_results(): HasMany {
        return $this->hasMany(GradeResult::class, 'studentId');
    }

    /**
     * The test additional results of the student
     */
    public function additional_results(): HasMany {
        return $this->hasMany(AdditionalResult::class, 'studentId');
    }

    /**
     * The test other results of the student
     */
    public function other_results(): HasMany {
        return $this->hasMany(OtherResult::class, 'userID');
    }

    /**
     * The test permanent results of the student
     */
    public function permanent_results(): HasMany {
        return $this->hasMany(PermanentResult::class, 'studentId');
    }

    /**
     * The review results of the student
     */
    public function review_results(): HasMany {
        return $this->hasMany(ReviewResult::class, 'studentId');
    }

    /**
     * Grade
     * !TO FIX: Grade isn't a real model
     */
    public function grade(): Grade {
        return $this->school_class->grade();
    }

    /**
     * Check if the student is in middle school
     */
    public function isMiddleSchoollegacy_student(): bool {
        return $this->school_class->isMiddleSchool();
    }

    /**
     * Check if the student is in high school
     */
    public function isHighSchoollegacy_student(): bool {
        return $this->school_class->isHighschool();
    }

    /**
     * Get the student's grade number at a specific date
     */
    public function gradeWhen(string $date): ?int {
        $grade = $this->school_class?->gradeWhen($date);

        if ($grade) {
            return $grade;
        }

        return null;
    }

    /**
     * Check if a student has completed a specific section
     */
    public function hasCompletedSection(Section $section): bool {
        return $this->section_results->where('sectionId', $section->id)->where('completed', true)->count();
    }

    /**
     * Check if a student has completed a specific test
     */
    public function hasCompletedTest(Test $test): bool {
        return $this->test_results->where('testId', $test->id)->where('completed', true)->count();
    }

    /**
     * Get the number of completed tests in a specific section
     */
    public function testsCompletedInSection(Section $section): int {
        return $this->test_results
            ->whereIn('testId', $section->tests->pluck('id'))
            ->where('completed', true)
            ->count();
    }

    /**
     * Get the percentage of completed tests in a specific section
     */
    public function percentageTestsCompletedInSection(Section $section): int {
        $totalTests = $section->tests->count();
        $completedTests = $this->testsCompletedInSection($section);

        if ($totalTests === 0) {
            return 0;
        }

        return round($completedTests / $totalTests * 100);
    }

    /**
     * Get the number of completed sections in a specific grade
     */
    public function sectionsCompletedInGrade(Grade $grade): int {
        return $this->section_results
            ->whereIn('sectionId', $grade->completable_sections->pluck('id'))
            ->where('completed', true)
            ->count();
    }

    /**
     * Get the percentage of completed sections in a specific grade
     */
    public function percentageSectionsCompletedInGrade(Grade $grade): int {
        $totalSections = $grade->completable_sections->count();
        $completedSections = $this->sectionsCompletedInGrade($grade);

        if ($totalSections === 0) {
            return 0;
        }

        return round($completedSections / $totalSections * 100);
    }

    /**
     * Get the test result for a specific test
     */
    public function testResult(Test $test): ?TestResult {
        return $this->test_results->where('testId', $test->id)->first();
    }

    /**
     * Get the section result for a specific section
     */
    public function sectionResult(Section $section): ?SectionResult {
        return $this->section_results->where('sectionId', $section->id)->first();
    }
}
