<?php

namespace App\Models\Results\User;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class TestResult extends Model
{
    private const ARCHIVE_TABLE = 'results_tests_archive';

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
     * Serialize changes even when there is no current result yet.
     */
    public static function lockParticipant(int $studentId): void
    {
        if (! DB::table('users')->where('id', $studentId)->lockForUpdate()->first()) {
            throw new \RuntimeException('Test participant not found.');
        }
    }

    /**
     * Move the current result to history. Call inside a participant-locked transaction.
     */
    public static function archiveCurrent(int $studentId, int $testId): void
    {
        $current = self::where('studentId', $studentId)
            ->where('testId', $testId)
            ->lockForUpdate()
            ->first();

        if ($current) {
            DB::table(self::ARCHIVE_TABLE)->insert($current->getRawOriginal());
            $current->delete();
        }
    }

    /**
     * Replace the current result while retaining the previous one.
     */
    public static function replaceCurrent(array $attributes): self
    {
        return DB::transaction(function () use ($attributes) {
            self::lockParticipant($attributes['studentId']);
            self::archiveCurrent($attributes['studentId'], $attributes['testId']);

            return self::create($attributes);
        });
    }

    /**
     * Static method: Count completed attempts grouped by test for a student.
     */
    public static function completedAttemptsByTestFor(Student|int $student, iterable $testIds): array
    {
        $studentId = $student instanceof Student ? $student->id : $student;

        $testIds = collect($testIds)->all();
        $counts = [];

        foreach (['results_tests', self::ARCHIVE_TABLE] as $table) {
            $attempts = DB::table($table)
                ->where('studentId', $studentId)
                ->whereIn('testId', $testIds)
                ->where('completed', true)
                ->selectRaw('testId, COUNT(*) as attempts')
                ->groupBy('testId')
                ->pluck('attempts', 'testId');

            foreach ($attempts as $testId => $count) {
                $counts[$testId] = ($counts[$testId] ?? 0) + (int) $count;
            }
        }

        return $counts;
    }
}
