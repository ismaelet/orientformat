<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use RuntimeException;

class StudentSectionResultCalculator {
    /**
     * Sections whose condensed result is the average
     * of their detailed result percentages.
     */
    private const AVERAGE_SECTION_IDS = [
        5,
        30,
        38,
        42,

        10,
        32,

        11,
        33,
        48,

        12,
        47,
        50,

        13,
        39,

        14,
        34,
        51,
        53,
        54,
        55,
        57,

        15,
        40,
        56,

        31,
    ];

    private const ATTENTION_SECTION_IDS = [
        9,
    ];

    private const MAIN_TEST_IDS = [
        // Stili cognitivi
        1 => 31,
        28 => 109,
        36 => 111,
        37 => 113,

        // Resilienza
        3 => 49,

        // Autostima
        4 => 15,
        29 => 107,
        41 => 146,

        // Stile attributivo
        6 => 48,

        // Motivazione
        7 => 20,

        // Temperamento
        8 => 46,

        // Creatività
        17 => 81,

        // Albero dei saperi informali
        18 => 82,

        // Interessi
        24 => 92,
        45 => 151,

        // Universo personale
        25 => 100,

        // L'albero della vita
        26 => 101,

        // Ruota delle emozioni
        27 => 116,
    ];

    private const FULL_RESULT_SKIPPED_TEST_IDS = [
        // Risolvere problemi
        5 => [94, 119, 147, 162],
        30 => [94, 119, 147, 162],
        38 => [94, 119, 147, 162],
        42 => [94, 119, 147, 162],

        // Ricordare
        10 => [56],
        32 => [56],
        49 => [56],

        // Ascoltare
        11 => [],
        33 => [],
        47 => [],
        48 => [],

        // Parlare
        12 => [],
        50 => [],

        // Leggere
        13 => [70],
        39 => [70],
        53 => [70],
        54 => [70],

        // Scrivere
        14 => [62, 63, 167, 168],
        34 => [62, 63, 167, 168],
        51 => [62, 63, 167, 168],
        55 => [62, 63, 167, 168],
        57 => [62, 63, 167, 168],

        // Imparare
        15 => [131],
        40 => [131],
        56 => [131],

        // Stare attenti
        31 => [],
    ];

    public function __construct(
        private StudentTestResultCalculator $studentTestResults,
    ) {
    }

    /**
     * Get the test IDs needed to calculate a section result.
     *
     * @return array<int>
     */
    public function requiredTestIds(Section $section): array {
        if ($section->id === 9) {
            return [
                16,
                21,
            ];
        }

        if (
            array_key_exists(
                $section->id,
                self::FULL_RESULT_SKIPPED_TEST_IDS,
            )
        ) {
            $skipTestIds =
                self::FULL_RESULT_SKIPPED_TEST_IDS[$section->id];

            return Test::query()
                ->where('sectionId', $section->id)
                ->whereNotIn('id', $skipTestIds)
                ->where('template', '!=', 'survey-results')
                ->pluck('id')
                ->map(fn($id) => (int) $id)
                ->all();
        }

        $mainTestId =
            self::MAIN_TEST_IDS[$section->id]
            ?? null;

        return $mainTestId !== null
            ? [$mainTestId]
            : [];
    }

    /**
     * Get the condensed result for a student and section.
     */
    public function result(
        Section $section,
        Student $student,
    ): mixed {
        if (
            in_array(
                $section->id,
                self::AVERAGE_SECTION_IDS,
                true,
            )
        ) {
            return $this->averageResult(
                section: $section,
                student: $student,
            );
        }

        if (
            in_array(
                $section->id,
                self::ATTENTION_SECTION_IDS,
                true,
            )
        ) {
            return $this->attentionResult(
                section: $section,
                student: $student,
            );
        }

        return $this->mainTestResult(
            section: $section,
            student: $student,
        );
    }

    /**
     * Get the detailed result for a student and section.
     */
    public function detailedResult(
        Section $section,
        Student $student,
    ): ?array {
        if ($section->id === 9) {
            return $this->attentionDetailedResult(
                student: $student,
            );
        }

        if (
            array_key_exists(
                $section->id,
                self::FULL_RESULT_SKIPPED_TEST_IDS,
            )
        ) {
            return $this->fullSectionDetailedResult(
                section: $section,
                student: $student,
            );
        }

        $mainTestId =
            self::MAIN_TEST_IDS[$section->id]
            ?? null;

        if ($mainTestId !== null) {
            return $this->studentTestResults
                ->detailedResult(
                    testId: $mainTestId,
                    student: $student,
                );
        }

        throw new RuntimeException(
            "Unsupported detailed result section [{$section->id}].",
        );
    }

    private function fullSectionDetailedResult(
        Section $section,
        Student $student,
    ): array {
        return $this->calculateFullSectionResults(
            section: $section,
            student: $student,
        );
    }

    /**
     * Calculate the average condensed result.
     */
    private function averageResult(
        Section $section,
        Student $student,
    ): ?string {
        $results = $this->detailedResult(
            section: $section,
            student: $student,
        );

        if (empty($results)) {
            return null;
        }

        $total = 0;

        foreach ($results as $result) {
            $total += $result['percentage'];
        }

        return round(
            $total / count($results),
        ) . '%';
    }

    private function mainTestResult(
        Section $section,
        Student $student,
    ): mixed {
        $testId = self::MAIN_TEST_IDS[$section->id] ?? null;

        if ($testId === null) {
            throw new RuntimeException(
                "Unsupported condensed result section [{$section->id}].",
            );
        }

        return $this->studentTestResults->result(
            testId: $testId,
            student: $student,
        );
    }

    private function calculateFullSectionResults(
        Section $section,
        Student $student,
    ): array {
        $skipTestIds =
            self::FULL_RESULT_SKIPPED_TEST_IDS[$section->id]
            ?? [];

        $tests = Test::query()
            ->where('sectionId', $section->id)
            ->orderBy('step')
            ->get();

        $results = [];

        foreach ($tests as $test) {
            if (
                in_array(
                    $test->id,
                    $skipTestIds,
                    true,
                )
            ) {
                continue;
            }

            if ($test->template === 'survey-results') {
                continue;
            }

            if (
                !$this->studentTestResults->isCompleted(
                    testId: $test->id,
                    student: $student,
                )
            ) {
                continue;
            }

            $result = $this->studentTestResults->result(
                testId: $test->id,
                student: $student,
            );

            if ($result === null) {
                continue;
            }

            $results[] = [
                'test' => $test->title,
                'percentage' => (int) rtrim(
                    (string) $result,
                    '%',
                ),
            ];
        }

        return $results;
    }

    private function calculateAttentionResult(
        Section $section,
        Student $student,
    ): ?string {
        $results = $this->detailedResult(
            section: $section,
            student: $student,
        );

        if (empty($results)) {
            return null;
        }

        if ($results) {
            $average = 0;

            if (isset($results['Autovalutazione'])) {
                $average += $results['Autovalutazione']['percentage'];
            }

            if (isset($results['Iperattività'])) {
                $average += 100 - $results['Iperattività']['percentage'];
            }

            if (isset($results['Distraibilità'])) {
                $average += 100 - $results['Distraibilità']['percentage'];
            }

            return round($average / count($results)) . '%';
        } else {
            return null;
        }
    }

    private function attentionResult(
        Section $section,
        Student $student,
    ): ?string {
        $modernResult = $this->calculateAttentionResult(
            section: $section,
            student: $student,
        );

        return $modernResult;
    }

    private function attentionDetailedResult(
        Student $student,
    ): ?array {
        return $this->calculateAttentionDetailedResult(
            student: $student,
        );
    }

    private function calculateAttentionDetailedResult(
        Student $student,
    ): ?array {
        $results = [];

        $selfEvaluationResult =
            $this->studentTestResults->detailedResult(
                testId: 16,
                student: $student,
            );

        $hyperactivityResults =
            $this->studentTestResults->detailedResult(
                testId: 21,
                student: $student,
            );

        if ($selfEvaluationResult !== null) {
            $results['Autovalutazione'] = [
                'name' => 'Autovalutazione',
                'value' => $selfEvaluationResult,
                'percentage' => $selfEvaluationResult,
            ];
        }

        if ($hyperactivityResults !== null) {
            foreach (
                $hyperactivityResults
                as $resultName => $result
            ) {
                $results[$resultName] = [
                    'name' => $resultName,
                    'value' => $result,
                    'percentage' => round(
                        $result / 36 * 100,
                    ),
                ];
            }
        }

        return empty($results)
            ? null
            : $results;
    }
}
