<?php

namespace App\Helpers;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Services\Results\StudentSectionResultCalculator;

class SectionResultHelper {

    /**
     * Get the result of a specific section for a specific student
     */
    public static function label(Student $student, Section $section): ?string {
        return match ($section->id) {
            // Result of simple one-test sections
            9, 31 => self::sectionSelfEvaluationResult($student, $section),

            // Result of agglomerates of tests
            3, 4, 10, 11, 12, 13, 14, 17, 29, 32, 33, 39, 41, 47, 48, 49, 50, 51, 53, 55, 57  => self::sectionAgglomeratedResult($student, $section),

            // Result of histogram sections
            5, 15, 30, 38, 40, 42, 56  => self::histogramResult($student, $section),

            // Results of traits sections
            1, 6, 7, 8, 28, 36, 37 => self::traitResult($student, $section),

            // Result of the "Ruota" section
            27, 58  => self::ruotaResult($student, $section),

            // Generic fallback
            default => self::calculator()->result(
                section: $section,
                student: $student,
            ),
        };
    }

    private static function calculator(): StudentSectionResultCalculator {
        return app(StudentSectionResultCalculator::class);
    }

    /**
     * Get the result of the self-evaluation test for a specific section
     */
    public static function sectionSelfEvaluationResult(Student $student, Section $section): ?string {
        $selfEvaluationTest = $section->evaluation_test;

        $selfEvaluationResult = TestResult::where('studentId', $student->id)
            ->where('testId', $selfEvaluationTest->id)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$selfEvaluationResult) {
            return null;
        }

        return $selfEvaluationResult->percentage . '%';
    }

    /**
     * Get the result of the agglomerated tests for a specific section
     */
    public static function sectionAgglomeratedResult(Student $student, Section $section): ?string {
        $selfEvaluationTest = $section->evaluation_test;

        $requiredTestIds = $selfEvaluationTest->dependent_tests()->pluck('id');

        $relatedResults = TestResult::where('studentId', $student->id)
            ->whereIn('testId', $requiredTestIds)
            ->where('completed', true)
            ->latest()
            ->orderBy('id', 'desc')
            ->get()
            ->unique('testId')
            ->values();

        if (!$relatedResults->count()) {
            return null;
        }

        $avgPercentage = round($relatedResults->avg('percentage'));

        return $avgPercentage . '%';
    }

    /**
     * Get the result of the histogram sections for a specific student
     */
    public static function histogramResult(Student $student, Section $section): ?string {
        $max = 5;
        $resultLabel = null;
        $selfEvaluationTest = $section->evaluation_test;

        $selfEvaluationResult = TestResult::where('studentId', $student->id)
            ->where('testId', $selfEvaluationTest->id)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($selfEvaluationResult) {
            $result = explode(',', $selfEvaluationResult->result);
            $resultCount = count($result);
            $maxResult = $resultCount * $max;
            $resultValue = array_sum($result);
            $resultLabel = round($resultValue / $maxResult * 100) . '%';
        }

        return $resultLabel;
    }

    /**
     * Get the result of the traits sections for a specific student
     */
    public static function traitResult(Student $student, Section $section): ?string {
        $selfEvaluationTest = $section->evaluation_test->load('section', 'required_test');

        $results = $selfEvaluationTest->helper()::results(student: $student, test: $selfEvaluationTest);

        if (!$results) {
            return null;
        }

        $results = $results->sortBy('name')->sortByDesc('percentage');

        $topTrait = $results->first();
        $topTraits = $results->where('percentage', $topTrait['percentage']);

        return implode(', ', $topTraits->pluck('name')->toArray());
    }

    /**
     * Get the result of the "Ruota" section for a specific student
     */
    public static function ruotaResult(Student $student, Section $section): ?string {
        $testIds = Test::where('sectionId', $section->id)
            ->where('step', '<=', $section->evaluation_test->step)
            ->pluck('id');

        $relatedResults = TestResult::where('studentId', $student->id)
            ->whereIn('testId', $testIds)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $results = [];

        $relatedResults->each(function ($item) use (&$results) {
            $results[] = ucfirst(__(explode(',', $item->result)[0]));
        });

        return implode(', ', $results);
    }
}
