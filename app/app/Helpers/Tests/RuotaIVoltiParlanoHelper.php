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

class RuotaIVoltiParlanoHelper implements TestHelperInterface {

    public const int FACE_COUNT = 8;
    public const int MOUTH_COUNT = 8;

    /**
     * This is a creative exercise, so every completed
     * submission receives 100%.
     */
    public function calculatePercentage(array $fields): int {
        return 100;
    }

    /**
     * Session key used while selecting another emotion.
     */
    private function sessionKey(
        Test $test,
        Student|Teacher $student
    ): string {
        return "tests.{$test->id}.{$student->getMorphClass()}.{$student->id}.rechoose";
    }

    /**
     * Provide additional data to the Blade view.
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

        $raw = $attempt?->getRawOriginal('result');

        // Split into at most three parts, preserving commas
        // within the emotion text if older results contain them.
        $values = $raw !== null
            ? explode(',', $raw, 3)
            : [];

        $selection = [
            'face' => isset($values[0]) ? (int) $values[0] : null,
            'mouth' => isset($values[1]) ? (int) $values[1] : null,
            'emotion' => $values[2] ?? '',
        ];

        return [
            'faceAttempt' => $attempt,
            'faceSelection' => $selection,
            'choosingAgain' => (bool) session(
                $this->sessionKey($test, $student),
                false
            ),
        ];
    }

    /**
     * Custom submission handling for this test.
     */
    public function store(
        Request $request,
        Test $test,
        Student|Teacher $student
    ): RedirectResponse {
        $sessionKey = $this->sessionKey($test, $student);

        // Start selecting a new emotion.
        if ($request->has('redo')) {
            session()->put($sessionKey, true);

            return redirect()->to($test->url());
        }

        $validated = $request->validate([
            'field' => ['required', 'array', 'size:3'],
            'field.0' => ['required', 'integer', 'between:1,8'],
            'field.1' => ['required', 'integer', 'between:1,8'],
            'field.2' => ['required', 'string', 'max:18'],
        ]);

        $fields = $validated['field'];

        DB::transaction(function () use (
            $test,
            $student,
            $fields
        ) {
            // Serialize submissions from the same participant.
            $student::query()
                ->whereKey($student->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $result = TestResult::query()
                ->where('studentId', $student->id)
                ->where('testId', $test->id)
                ->latest('id')
                ->lockForUpdate()
                ->first();

            $wasCompleted = (bool) $result?->completed;

            if (!$result) {
                $result = new TestResult();
                $result->studentId = $student->id;
                $result->testId = $test->id;
            }

            $result->result = implode(',', [
                (int) $fields[0],
                (int) $fields[1],
                trim($fields[2]),
            ]);

            $result->percentage = $this->calculatePercentage($fields);
            $result->completed = true;
            $result->save();

            if (!$wasCompleted) {
                $test->section->updateProgress($student);
            }
        });

        session()->forget($sessionKey);

        // Return to this test to display the chosen emotion.
        return redirect()->to($test->url());
    }
}
