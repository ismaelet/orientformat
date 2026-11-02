<?php

namespace App\Models\Results\User;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    /**
     * The table associated with the model
     */
    protected $table = 'results_tests';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'studentId',
        'testId',
        'completed',
        'result',
        'percentage',
        'speed',
    ];

    /**
     * Relationship: The student who took the test
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'studentId');
    }

    /**
     * Relationship: The test associated with the result
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'testId');
    }

    /**
     * Check if the test is completed
     */
    public function completed(): bool
    {
        return $this->completed;
    }

    /**
     * Get the results as an array
     */
    public function results(): array
    {
        return explode(',', $this->result);
    }

    /**
     * Static method: Count completed attempts grouped by test for a student.
     */
    public static function completedAttemptsByTestFor(Student|int $student, iterable $testIds): array
    {
        $studentId = $student instanceof Student ? $student->id : $student;

        return self::where('studentId', $studentId)
            ->whereIn('testId', $testIds)
            ->where('completed', true)
            ->selectRaw('testId, COUNT(*) as attempts')
            ->groupBy('testId')
            ->pluck('attempts', 'testId')
            ->map(fn ($attempts) => (int) $attempts)
            ->toArray();
    }
}
