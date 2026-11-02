<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RicordareCifreHelper implements TestHelperInterface
{
    public const int MAX_LEVEL = 8;

    public const array ANSWERS = [
        1 => [9, 2, 4],
        2 => [5, 0, 3, 1],
        3 => [4, 8, 7, 9, 1],
        4 => [2, 6, 3, 0, 9, 5],
        5 => [1, 7, 4, 2, 9, 0, 2],
        6 => [2, 6, 3, 9, 0, 5, 4, 7],
        7 => [2, 9, 5, 7, 3, 4, 8, 1, 6],
        8 => [0, 5, 3, 1, 7, 9, 2, 4, 7, 3],
    ];

    /**
     * Get the data required for the test view for the given student and test.
     */
    public function viewData(
        Test $test,
        Student|Teacher $student
    ): array {
        $attempt = TestResult::query()
            ->where('studentId', $student->id)
            ->where('testId', $test->id)
            ->latest('id')
            ->first();

        return [
            'state' => $this->state($attempt),
            'memoryAttempt' => $attempt,
        ];
    }

    /**
     * Determine the current state of the test based on the provided result.
     */
    public function state(?TestResult $result): array
    {
        $raw = $result?->getRawOriginal('result');

        $values = $raw !== null && $raw !== ''
            ? array_map('intval', explode(',', $raw))
            : [];

        $previousLevel = $values[0] ?? 0;

        // Validate the stored level before accessing ANSWERS.
        $previousLevel = max(
            0,
            min($previousLevel, self::MAX_LEVEL)
        );

        $previousAnswers = array_slice($values, 1);

        $right = $previousAnswers === [];

        if ($previousAnswers !== []) {
            $right = isset(self::ANSWERS[$previousLevel])
                && $previousAnswers === self::ANSWERS[$previousLevel];
        }

        $level = $right
            ? $previousLevel + 1
            : $previousLevel;

        $level = max(1, $level);

        return [
            'level' => $level,
            'previousLevel' => $previousLevel,
            'previousAnswers' => $previousAnswers,
            'right' => $right,
            'finished' => $level > self::MAX_LEVEL,
            'sequence' => self::ANSWERS[$level] ?? [],
            'awaitingRetry' => $previousAnswers !== [] && ! $right,
        ];
    }

    /**
     * Calculate the percentage of passed levels based on the provided fields.
     */
    public function calculatePercentage(array $fields): int
    {
        $passedLevels = (int) ($fields[0] ?? 0);

        return (int) round(
            min(max($passedLevels, 0), self::MAX_LEVEL)
                / self::MAX_LEVEL * 100
        );
    }

    /**
     * Check whether the submitted sequence is correct.
     */
    public function checkAnswer(int $level, array $answers): bool
    {
        return isset(self::ANSWERS[$level])
            && array_values(array_map('intval', $answers))
            === self::ANSWERS[$level];
    }

    /**
     * Store the test result for the given student and test.
     */
    public function store(
        Request $request,
        Test $test,
        Student|Teacher $student
    ): RedirectResponse {
        return DB::transaction(function () use ($request, $test, $student) {

            // Serialize submissions for this student.
            // Locking the student row also protects the first submission,
            // before a TestResult record exists.
            $student::query()
                ->whereKey($student->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            // Retrieve the latest attempt, including incomplete results.
            $result = TestResult::query()
                ->where('studentId', $student->id)
                ->where('testId', $test->id)
                ->latest('id')
                ->lockForUpdate()
                ->first();

            // Prevent changes to a completed attempt.
            if ($result?->completed) {
                return redirect()->to($test->nextUrl($student));
            }

            $state = $this->state($result);
            $level = $state['level'];

            // Exactly one action must be submitted.
            $actions = array_filter([
                'check' => $request->has('check'),
                'reset' => $request->has('reset'),
                'submit' => $request->has('submit'),
            ]);

            if (count($actions) !== 1) {
                abort(422, 'Invalid test action.');
            }

            $action = array_key_first($actions);

            // Prepare the existing or new result.
            if (! $result) {
                $result = new TestResult;
                $result->studentId = $student->id;
                $result->testId = $test->id;
            }

            // Retry after an incorrect answer.
            if ($action === 'reset') {
                if (! $state['awaitingRetry']) {
                    abort(422, 'Retry is not available.');
                }

                // Remove the incorrect answer while preserving the level.
                $result->result = (string) ($state['level'] - 1);
                $result->percentage = $this->calculatePercentage([
                    $level - 1,
                ]);
                $result->completed = false;

                $result->save();

                return redirect()->to($test->url());
            }

            // Finish the test.
            if ($action === 'submit') {
                $passedLevels = min(
                    self::MAX_LEVEL,
                    $level - 1
                );

                $result->result = (string) $passedLevels;
                $result->percentage = $this->calculatePercentage([
                    $passedLevels,
                ]);
                $result->completed = true;

                $result->save();

                // Only update progress after final completion.
                $test->section->updateProgress($student);

                return redirect()->to($test->nextUrl($student));
            }

            // Check the submitted number sequence.
            if ($action === 'check') {
                if ($state['awaitingRetry']) {
                    abort(422, 'Retry the current level first.');
                }

                if ($state['finished']) {
                    abort(422, 'All levels are already completed.');
                }

                $expectedCount = count($state['sequence']);

                $validated = $request->validate([
                    'field' => [
                        'required',
                        'array',
                        'size:'.$expectedCount,
                    ],
                    'field.*' => [
                        'required',
                        'integer',
                        'between:0,9',
                    ],
                ]);

                $answers = array_values(
                    array_map('intval', $validated['field'])
                );

                $right = $this->checkAnswer($level, $answers);

                $passedLevels = $right
                    ? $level
                    : $level - 1;

                // Preserve the attempted level and its answers.
                $result->result = implode(',', [
                    $level,
                    ...$answers,
                ]);

                $result->percentage = $this->calculatePercentage([
                    $passedLevels,
                ]);

                $result->completed = false;

                $result->save();

                return redirect()->to($test->url());
            }

            abort(422, 'Invalid test action.');
        });
    }
}
