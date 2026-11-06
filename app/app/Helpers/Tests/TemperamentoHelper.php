<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;
use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class TemperamentoHelper implements TestHelperInterface
{
    public const QUESTION_COUNT = 4;

    public function viewData(Test $test): array
    {
        $questions = [];

        for ($number = 1; $number <= self::QUESTION_COUNT; $number++) {
            $questions[] = [
                __('tests.'.$test->id.'-answer-'.$number.'-negative'),
                __('tests.'.$test->id.'-answer-'.$number.'-positive'),
            ];
        }

        $oldAnswers = old('field', []);
        $answers = [];

        for ($index = 0; $index < self::QUESTION_COUNT; $index++) {
            $value = is_array($oldAnswers) ? ($oldAnswers[$index] ?? null) : null;
            $answers[] = in_array($value, [0, 1, 2, 3, 4, 5, '0', '1', '2', '3', '4', '5'], true)
                ? (string) $value
                : null;
        }

        return ['questions' => $questions, 'answers' => $answers];
    }

    public function calculatePercentage(array $submittedAnswers): int
    {
        return (int) round(array_sum($submittedAnswers) / (self::QUESTION_COUNT * 5) * 100);
    }

    public function store(Request $request, Test $test, Student|Teacher $student): RedirectResponse
    {
        if ($student->hasCompletedTest($test)) {
            return redirect()->to($test->nextUrl($student));
        }

        $validated = $request->validate([
            'field' => ['required', 'array', 'list', 'size:'.self::QUESTION_COUNT],
            'field.*' => ['required', 'integer', 'between:0,5'],
            'speed' => ['sometimes', 'integer', 'min:0'],
        ]);

        $test->storeResult(
            student: $student,
            fields: $validated['field'],
            timePassed: $request->integer('speed', 0),
            request: $request,
        );

        return redirect()->to($test->nextUrl($student));
    }
}
