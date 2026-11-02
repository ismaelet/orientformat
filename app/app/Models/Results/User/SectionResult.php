<?php

namespace App\Models\Results\User;

use App\Helpers\SectionResultHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Services\Results\StudentSectionResultCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionResult extends Model
{
    /**
     * The table associated with the model
     */
    protected $table = 'results_sections';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'studentId',
        'sectionId',
        'completedTestCount',
        'lastCompletedStep',
        'progressPercentage',
        'completed',
    ];

    /**
     * Relationship: The student associated with the result
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'studentId');
    }

    /**
     * Relationship: The section associated with the result
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'sectionId');
    }

    /**
     * Get the verbose result of the student in the section.
     */
    public function verboseResult(): ?string
    {
        return app(
            StudentSectionResultCalculator::class,
        )->result(
            section: $this->section,
            student: $this->student,
        );
    }

    /**
     * Get the label for the section result
     */
    public function label(): ?string
    {
        return SectionResultHelper::label($this->student, $this->section);
    }

    /**
     * Get the speed of the student in the section
     */
    public function speed(): ?int
    {
        $testIds = Test::query()
            ->where('sectionId', $this->sectionId)
            ->pluck('id');

        return TestResult::query()
            ->where('studentId', $this->studentId)
            ->whereIn('testId', $testIds)
            ->sum('speed');
    }

    /**
     * Get the verbose string representation of the speed
     */
    public function verboseSpeed(): ?string
    {
        if ($this->speed() >= 60) {
            $minutes = round($this->speed() / 60);

            $speed = $minutes;
            $speed .= $minutes == 1 ? ' minuto' : ' minuti';
        } elseif ($this->speed()) {
            $seconds = $this->speed();

            $speed = $seconds;
            $speed .= $seconds == 1 ? ' secondo' : ' secondi';
        }

        return $speed ?? null;
    }
}
