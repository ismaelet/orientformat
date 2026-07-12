<?php

namespace App\Services\Results;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use RuntimeException;

class StudentTestResultCalculator {
    /**
     * Tests whose condensed result is the name
     * of the detailed result with the highest value.
     */
    private const MAX_NAME_VALUE_TEST_IDS = [
        // Motivazione
        20,

        // Stili cognitivi
        31,
        113,

        // Temperamento
        46,

        // Interessi
        92,
        109,
        111,
        151,

        // Stile attributivo
        48,
    ];

    /**
     * Tests whose condensed result is the average
     * of detailed-result percentages.
     */
    private const AVERAGE_PERCENTAGE_TEST_IDS = [
        // Autostima
        15,
        107,
        146,

        // Scrivere - mappa degli stili
        63,
        168,

        // Creatività
        81,
    ];

    private const GENERIC_RESULT_TEST_IDS = [
        // Resilienza
        49,
    ];

    private const MERGED_NAME_TEST_IDS = [
        116,
    ];

    private const DETAILED_RESULT_TEST_IDS = [
        101,
    ];

    private const COMPLETED_TEST_IDS = [
        82,
        100,
    ];

    private const COGNITIVE_STYLE_TEST_IDS = [
        31,
        109,
        111,
        113,
    ];

    private const TESTS_AVERAGE_DETAILED_TEST_IDS = [
        // Autostima
        15,
        107,
        146,

        // Creatività
        81,
    ];

    private const INTEREST_TEST_IDS = [
        92,
        151,
    ];

    private const GENERIC_DETAILED_TEST_IDS = [
        // Resilienza
        49,

        // Albero dei saperi informali
        82,

        // Universo personale
        100,
    ];

    /**
     * Completed test results already loaded during the current request.
     *
     * @var array<string, TestResult|null>
     */
    private array $completedResultCache = [];

    /**
     * Test models already loaded during the current request.
     *
     * @var array<int, Test>
     */
    private array $testCache = [];

    /**
     * Preload the latest completed results for multiple students and tests.
     *
     * @param iterable<int, Student> $students
     * @param iterable<int, int> $testIds
     */
    public function preloadCompletedResults(
        iterable $students,
        iterable $testIds,
    ): void {
        $studentIds = collect($students)
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $testIds = collect($testIds)
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        if ($studentIds->isEmpty() || $testIds->isEmpty()) {
            return;
        }

        $results = TestResult::query()
            ->whereIn('studentId', $studentIds)
            ->whereIn('testId', $testIds)
            ->where('completed', true)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->unique(
                fn(TestResult $result) =>
                "{$result->studentId}:{$result->testId}",
            )
            ->keyBy(
                fn(TestResult $result) =>
                "{$result->studentId}:{$result->testId}",
            );

        foreach ($studentIds as $studentId) {
            foreach ($testIds as $testId) {
                $cacheKey = "{$studentId}:{$testId}";

                $this->completedResultCache[$cacheKey] =
                    $results->get($cacheKey);
            }
        }
    }

    /**
     * Expand main test IDs with the tests needed by their calculations.
     *
     * @param iterable<int, int> $testIds
     *
     * @return array<int>
     */
    public function expandRequiredTestIds(
        iterable $testIds,
    ): array {
        $testIds = collect($testIds)
            ->map(fn($id) => (int) $id)
            ->unique();

        $tests = Test::query()
            ->whereIn('id', $testIds)
            ->get()
            ->keyBy('id');

        $expandedIds = $testIds->all();

        foreach ($testIds as $testId) {
            $test = $tests->get($testId);

            if ($test?->required_test_id) {
                $expandedIds[] =
                    (int) $test->required_test_id;
            }

            if (
                in_array(
                    $testId,
                    self::TESTS_AVERAGE_DETAILED_TEST_IDS,
                    true,
                )
                && $test
            ) {
                $previousTestIds = Test::query()
                    ->where('sectionId', $test->sectionId)
                    ->where('step', '<', $test->step)
                    ->pluck('id')
                    ->all();

                $expandedIds = [
                    ...$expandedIds,
                    ...$previousTestIds,
                ];
            }

            if ($testId === 46 && $test) {
                $temperamentTestIds = Test::query()
                    ->where('sectionId', $test->sectionId)
                    ->whereBetween('step', [1, 5])
                    ->pluck('id')
                    ->all();

                $expandedIds = [
                    ...$expandedIds,
                    ...$temperamentTestIds,
                ];
            }

            if ($testId === 116) {
                $expandedIds = [
                    ...$expandedIds,
                    102,
                    115,
                    116,
                ];
            }
        }

        return collect($expandedIds)
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    private function test(int $testId): Test {
        return $this->testCache[$testId] ??=
            Test::query()->findOrFail($testId);
    }

    public function isCompleted(
        int $testId,
        Student $student,
    ): bool {
        return $this->latestCompletedResult(
            testId: $testId,
            student: $student,
        ) !== null;
    }

    /**
     * Get the condensed result for a student and test.
     */
    public function result(
        int $testId,
        Student $student,
    ): mixed {
        return match (true) {
            in_array(
                $testId,
                self::MAX_NAME_VALUE_TEST_IDS,
                true,
            ) => $this->maxNameValueResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::AVERAGE_PERCENTAGE_TEST_IDS,
                true,
            ) => $this->averagePercentageResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::MERGED_NAME_TEST_IDS,
                true,
            ) => $this->mergedNamesResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::DETAILED_RESULT_TEST_IDS,
                true,
            ) => $this->detailedResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::COMPLETED_TEST_IDS,
                true,
            ) => $this->completedResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::GENERIC_RESULT_TEST_IDS,
                true,
            ) => $this->genericResult(
                testId: $testId,
                student: $student,
            ),

            default => throw new RuntimeException(
                "Unsupported condensed test result [{$testId}].",
            ),
        };
    }

    private function genericResult(
        int $testId,
        Student $student,
    ): ?string {
        $result = $this->latestCompletedResult(
            testId: $testId,
            student: $student,
        );

        return $result
            ? $result->percentage . '%'
            : null;
    }

    /**
     * Get the detailed result for a student and test.
     */
    public function detailedResult(
        int $testId,
        Student $student,
    ): mixed {
        return match (true) {
            $testId === 16 => $this->attentionSelfEvaluationDetailedResult(
                student: $student,
            ),

            $testId === 20 => $this->motivationDetailedResult(
                student: $student,
            ),

            $testId === 21 => $this->attentionHyperactivityDetailedResult(
                student: $student,
            ),

            in_array(
                $testId,
                self::COGNITIVE_STYLE_TEST_IDS,
                true,
            ) => $this->cognitiveStyleDetailedResult(
                testId: $testId,
                student: $student,
            ),

            $testId === 46 => $this->temperamentDetailedResult(
                student: $student,
            ),

            $testId === 48 => $this->attributionStyleDetailedResult(
                student: $student,
            ),

            in_array(
                $testId,
                self::GENERIC_DETAILED_TEST_IDS,
                true,
            ) => $this->genericDetailedResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::TESTS_AVERAGE_DETAILED_TEST_IDS,
                true,
            ) => $this->testsAverageDetailedResult(
                testId: $testId,
                student: $student,
            ),

            in_array(
                $testId,
                self::INTEREST_TEST_IDS,
                true,
            ) => $this->interestsDetailedResult(
                testId: $testId,
                student: $student,
            ),

            $testId === 101 => $this->lifeTreeDetailedResult(
                student: $student,
            ),

            $testId === 116 => $this->emotionWheelDetailedResult(
                student: $student,
            ),

            default => throw new RuntimeException(
                "Unsupported detailed test result [{$testId}].",
            ),
        };
    }

    private function genericDetailedResult(
        int $testId,
        Student $student,
    ): ?array {
        return $this->rawResults(
            testId: $testId,
            student: $student,
        );
    }

    /**
     * Return the name belonging to the highest detailed value.
     */
    private function maxNameValueResult(
        int $testId,
        Student $student,
    ): ?string {
        $results = $this->detailedResult(
            testId: $testId,
            student: $student,
        );

        $mainStyle = null;
        $maximumValue = 0;

        if ($results) {
            foreach ($results as $result) {
                if ($result['value'] >= $maximumValue) {
                    $mainStyle = $result['name'];
                    $maximumValue = $result['value'];
                }
            }
        }

        return $mainStyle;
    }

    private function testsAverageDetailedResult(
        int $testId,
        Student $student,
    ): array {
        $mainTest = $this->test($testId);

        $previousTests = Test::query()
            ->where('sectionId', $mainTest->sectionId)
            ->where('step', '<', $mainTest->step)
            ->orderBy('step')
            ->get();

        $results = [];

        foreach ($previousTests as $test) {
            $testResult = $this->latestCompletedResult(
                testId: $test->id,
                student: $student,
            );

            if (!$testResult) {
                continue;
            }

            $results[] = [
                'name' => $test->title,
                'value' => $testResult->percentage,
                'percentage' => $testResult->percentage,
            ];
        }

        return $results;
    }

    /**
     * Return the average of detailed percentages.
     */
    private function averagePercentageResult(
        int $testId,
        Student $student,
    ): ?string {
        $results = $this->detailedResult(
            testId: $testId,
            student: $student,
        );

        $percentage = 0;
        $count = 0;

        foreach ($results ?? [] as $result) {
            $percentage += $result['percentage'];
            $count++;
        }

        return $count
            ? round($percentage / $count) . '%'
            : null;
    }

    /**
     * Return the merged names of detailed results.
     */
    private function mergedNamesResult(
        int $testId,
        Student $student,
    ): ?string {
        $results = $this->detailedResult(
            testId: $testId,
            student: $student,
        );

        if (empty($results)) {
            return null;
        }

        return implode(
            ', ',
            array_column(
                $results,
                'name',
            ),
        );
    }

    /**
     * Return 'Completato' if the test is completed, otherwise null.
     */
    private function completedResult(
        int $testId,
        Student $student,
    ): ?string {
        return $this->latestCompletedResult(
            testId: $testId,
            student: $student,
        )
            ? 'Completato'
            : null;
    }

    private function latestCompletedResult(
        int $testId,
        Student $student,
    ): ?TestResult {
        $cacheKey = "{$student->id}:{$testId}";

        if (
            array_key_exists(
                $cacheKey,
                $this->completedResultCache,
            )
        ) {
            return $this->completedResultCache[$cacheKey];
        }

        return $this->completedResultCache[$cacheKey] =
            TestResult::query()
            ->where('studentId', $student->id)
            ->where('testId', $testId)
            ->where('completed', true)
            ->latest('created_at')
            ->latest('id')
            ->first();
    }

    private function rawResults(
        int $testId,
        Student $student,
    ): ?array {
        $result = $this->latestCompletedResult(
            testId: $testId,
            student: $student,
        );

        if (!$result || $result->result === null || $result->result === '') {
            return null;
        }

        return explode(',', $result->result);
    }

    private function percentageResult(
        int $testId,
        Student $student,
    ): ?int {
        $result = $this->latestCompletedResult(
            testId: $testId,
            student: $student,
        );

        if (!$result) {
            return null;
        }

        return $result->percentage;
    }

    private function emotionWheelDetailedResult(
        Student $student,
    ): array {
        $testIds = [
            102,
            115,
            116,
        ];

        $emotions = [];

        foreach ($testIds as $testId) {
            $rawResults = $this->rawResults(
                testId: $testId,
                student: $student,
            );

            if (!$rawResults) {
                continue;
            }

            $emotion = $rawResults[0] ?? null;
            $intensity = isset($rawResults[1])
                ? (int) $rawResults[1]
                : null;

            if ($emotion === null || $intensity === null) {
                continue;
            }

            $emotions[] = [
                'name' => __($emotion),
                'value' => $intensity,
                'percentage' => round(
                    $intensity / 4 * 100,
                ),
            ];
        }

        return $emotions;
    }

    private function lifeTreeDetailedResult(
        Student $student,
    ): mixed {
        $rawResults = $this->rawResults(
            testId: 101,
            student: $student,
        );

        $characterId = isset($rawResults[0])
            ? (int) $rawResults[0]
            : null;

        if (!$characterId) {
            return null;
        }

        $characters = test_config(
            101,
            'characters',
        );

        return $characters[$characterId - 1] ?? null;
    }

    private function attentionSelfEvaluationDetailedResult(
        Student $student,
    ): ?int {
        return $this->percentageResult(
            testId: 16,
            student: $student,
        );
    }

    private function attentionHyperactivityDetailedResult(
        Student $student,
    ): ?array {
        $rawResults = $this->rawResults(
            testId: 21,
            student: $student,
        );

        if (empty($rawResults)) {
            return null;
        }

        $results = [
            'Iperattività' => 0,
            'Distraibilità' => 0,
        ];

        foreach ($rawResults as $key => $value) {
            $value = (int) $value;

            if ($key % 2) {
                $results['Iperattività'] += $value;
            } else {
                $results['Distraibilità'] += $value;
            }
        }

        return $results;
    }

    private function cognitiveStyleDetailedResult(
        int $testId,
        Student $student,
    ): array {
        $test = $this->test($testId);

        $requiredTestId = $test->required_test_id;

        if (!$requiredTestId) {
            return [];
        }

        $rawResults = $this->rawResults(
            testId: $requiredTestId,
            student: $student,
        );

        if (empty($rawResults)) {
            return [];
        }

        $groups = test_config(
            $testId,
            'groups',
        );

        $results = [];

        foreach ($groups as $groupId => $group) {
            $value = 0;

            foreach ($group['questionIds'] as $questionId) {
                $value += (int) (
                    $rawResults[$questionId] ?? 0
                );
            }

            $maximum = 9;

            $results[$groupId] = [
                'name' => $group['name'],
                'translated_name' => $group['translated_name'],
                'value' => $value,
                'max' => $maximum,
                'percentage' => round(
                    $value / $maximum * 100,
                ),
            ];
        }

        return $results;
    }

    private function attributionStyleDetailedResult(
        Student $student,
    ): ?array {
        $test = $this->test(48);

        $requiredTestId = $test->required_test_id;

        if (!$requiredTestId) {
            return null;
        }

        $rawResults = $this->rawResults(
            testId: $requiredTestId,
            student: $student,
        );

        if (empty($rawResults)) {
            return null;
        }

        $styles = test_config(48, 'styles');
        $counts = [];

        foreach ($styles as $style) {
            $counts[$style] = 0;
        }

        foreach ($rawResults as $value) {
            $styleIndex = (int) $value - 1;
            $style = $styles[$styleIndex] ?? null;

            if ($style === null) {
                continue;
            }

            $counts[$style]++;
        }

        $results = [];

        foreach ($counts as $style => $count) {
            $results[] = [
                'name' => $style,
                'value' => $count,
                'percentage' => percent(
                    $count,
                    8,
                ),
            ];
        }

        return $results;
    }

    private function motivationDetailedResult(
        Student $student,
    ): array {
        $test = $this->test(20);

        $requiredTestId = $test->required_test_id;

        if (!$requiredTestId) {
            return [];
        }

        $rawResults = $this->rawResults(
            testId: $requiredTestId,
            student: $student,
        );

        if (empty($rawResults)) {
            return [];
        }

        $areas = test_config(20, 'areas');
        $questions = test_config(20, 'questions');

        $results = [];

        foreach ($areas as $area) {
            $results[] = [
                'name' => $area[0],
                'value' => 0,
            ];
        }

        foreach ($questions as $questionId => $question) {
            $areaId = $question[1];

            $results[$areaId - 1]['value'] +=
                (int) ($rawResults[$questionId] ?? 0);
        }

        foreach ($results as &$area) {
            $area['percentage'] = percent(
                $area['value'],
                16,
            );
        }

        unset($area);

        return $results;
    }

    private function temperamentDetailedResult(
        Student $student,
    ): ?array {
        $mainTest = $this->test(46);

        $sectionNames = test_config(
            46,
            'sections',
        );

        $tests = Test::query()
            ->where('sectionId', $mainTest->sectionId)
            ->whereBetween('step', [1, 5])
            ->orderBy('step')
            ->get()
            ->keyBy('step');

        $results = [];

        for ($step = 1; $step <= 5; $step++) {
            $test = $tests->get($step);

            if (!$test) {
                continue;
            }

            $testResult = $this->latestCompletedResult(
                testId: $test->id,
                student: $student,
            );

            if (!$testResult) {
                continue;
            }

            $percentage = (int) $testResult->percentage;

            $results[] = [
                'name' => $sectionNames[$step - 1],
                'value' => round(
                    $percentage / 100 * 6,
                ),
                'percentage' => $percentage,
            ];
        }

        return empty($results)
            ? null
            : $results;
    }

    private function interestsDetailedResult(
        int $testId,
        Student $student,
    ): array {
        $test = $this->test($testId);

        $requiredTestId = $test->required_test_id;

        if (!$requiredTestId) {
            return [];
        }

        $rawResults = $this->rawResults(
            testId: $requiredTestId,
            student: $student,
        );

        if (empty($rawResults)) {
            return [];
        }

        $groups = test_config(
            $testId,
            'groups',
        );

        $results = [];

        foreach ($groups as $groupId => $group) {
            $result = [
                'id' => $groupId,
                'name' => $group['name'],
                'value' => 0,
                'max' => count(
                    $group['questionIds'],
                ) * 3,
            ];

            foreach (
                $group['questionIds']
                as $questionId
            ) {
                $value =
                    $rawResults[$questionId - 1]
                    ?? 0;

                $result['value'] += $value
                    ? (int) $value - 1
                    : 0;
            }

            $result['percentage'] = round(
                $result['value']
                    / $result['max']
                    * 100,
            );

            $results[] = $result;
        }

        return $results;
    }
}
