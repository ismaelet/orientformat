<?php

namespace App\Services\Results;

use App\Helpers\Tests\ScrivereSemplificatoMappaHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Support\SectionResultDefinitions;
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

    private const SCRIVERE_SEMPLIFICATO_SECTION_ID = 34;

    private const SCRIVERE_SEMPLIFICATO_TEST_ID = 62;

    public function __construct(
        private StudentTestResultCalculator $studentTestResults,
    ) {
    }

    /**
     * Preload the test results needed to calculate a section.
     *
     * @param iterable<int, Student> $students
     */
    public function preloadResults(
        Section $section,
        iterable $students,
    ): void {
        $testIds = $this->requiredTestIds($section);

        $expandedTestIds =
            $this->studentTestResults->expandRequiredTestIds(
                $testIds,
            );

        $this->studentTestResults->preloadCompletedResults(
            students: $students,
            testIds: $expandedTestIds,
        );
    }

    public function clearPreloadedResults(): void {
        $this->studentTestResults
            ->clearCompletedResultCache();
    }

    /**
     * Get the test IDs needed to calculate a section result.
     *
     * @return array<int>
     */
    public function requiredTestIds(
        Section $section,
    ): array {
        if ($section->id === 9) {
            return [
                16,
                21,
            ];
        }

        if (
            SectionResultDefinitions::usesFullSectionResults(
                $section->id,
            )
        ) {
            $skipTestIds =
                SectionResultDefinitions::skippedTestIds(
                    $section->id,
                );

            return Test::query()
                ->where('sectionId', $section->id)
                ->whereNotIn('id', $skipTestIds)
                ->where(
                    fn($query) => $query
                        ->whereNull('template')
                        ->orWhere(
                            'template',
                            '!=',
                            'survey-results',
                        ),
                )
                ->pluck('id')
                ->map(
                    fn($id): int => (int) $id,
                )
                ->all();
        }

        $mainTestId =
            SectionResultDefinitions::mainTestId(
                $section->id,
            );

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
            $section->id
            === self::SCRIVERE_SEMPLIFICATO_SECTION_ID
        ) {
            return $this->scrivereSemplificatoResult(
                student: $student,
            );
        }

        if (
            SectionResultDefinitions::usesFullSectionResults($section->id)
        ) {
            return $this->fullSectionDetailedResult(
                section: $section,
                student: $student,
            );
        }

        $mainTestId = SectionResultDefinitions::mainTestId(
            $section->id,
        );

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
        $skipTestIds =
            SectionResultDefinitions::skippedTestIds(
                $section->id,
            );

        $results = [];

        $tests = $section->active_tests()
            ->orderBy('step')
            ->get();

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
                'percentage' => (int) $result,
            ];
        }

        return $results;
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
        $testId = SectionResultDefinitions::mainTestId(
            $section->id,
        );

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
            SectionResultDefinitions::skippedTestIds($section->id);

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

    private function attentionResult(
        Student $student,
    ): ?string {
        $detailedResult = $this->attentionDetailedResult(
            student: $student,
        );

        if (empty($detailedResult)) {
            return null;
        }

        $total = 0;

        if (isset($detailedResult['Autovalutazione'])) {
            $total +=
                $detailedResult['Autovalutazione']['percentage'];
        }

        if (isset($detailedResult['Iperattività'])) {
            $total +=
                100
                - $detailedResult['Iperattività']['percentage'];
        }

        if (isset($detailedResult['Distraibilità'])) {
            $total +=
                100
                - $detailedResult['Distraibilità']['percentage'];
        }

        return round(
            $total / count($detailedResult),
        ) . '%';
    }

    private function attentionDetailedResult(
        Student $student,
    ): ?array {
        $results = [];

        $selfEvaluation =
            $this->studentTestResults->detailedResult(
                testId: 16,
                student: $student,
            );

        $hyperactivity =
            $this->studentTestResults->detailedResult(
                testId: 21,
                student: $student,
            );

        if ($selfEvaluation !== null) {
            $results['Autovalutazione'] = [
                'name' => 'Autovalutazione',
                'value' => $selfEvaluation,
                'percentage' => $selfEvaluation,
            ];
        }

        if ($hyperactivity !== null) {
            foreach ($hyperactivity as $name => $value) {
                $results[$name] = [
                    'name' => $name,
                    'value' => $value,
                    'percentage' => round(
                        $value / 36 * 100,
                    ),
                ];
            }
        }

        return empty($results)
            ? null
            : $results;
    }

    /**
     * Return the 16 Scrivere semplificato values for one student.
     *
     * @return array<int, array{
     *     name: string,
     *     percentage: float
     * }>|null
     */
    private function scrivereSemplificatoResult(
        Student $student,
    ): ?array {
        $testResult = TestResult::query()
            ->where(
                'testId',
                self::SCRIVERE_SEMPLIFICATO_TEST_ID,
            )
            ->where('studentId', $student->id)
            ->where('completed', true)
            ->first();

        if (!$testResult?->result) {
            return null;
        }

        $values = array_map(
            static fn(string $value): int =>
            (int) trim($value),
            explode(',', $testResult->result),
        );

        $types = app(
            ScrivereSemplificatoMappaHelper::class,
        )->getTypes();

        if (
            count($values) !== count($types)
            || count($types) !== 16
        ) {
            return null;
        }

        foreach ($values as $value) {
            if ($value < 1 || $value > 6) {
                return null;
            }
        }

        return collect($types)
            ->map(
                fn(
                    string $type,
                    int $index,
                ): array => [
                    'name' => $type,
                    'percentage' =>
                    $this->scrivereSemplificatoPercentage(
                        $values[$index],
                    ),
                ],
            )
            ->values()
            ->all();
    }

    /**
     * Convert a score from 1–6 to a percentage from 0–100.
     */
    private function scrivereSemplificatoPercentage(
        int $value,
    ): int {
        return (int) round(
            ($value - 1) / 5 * 100,
        );
    }
}
