<?php

namespace App\Services\Results;

use App\Models\User\Student;
use Legacy\Activity\Result\Handler\StudentTestResult;

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

    private const MERGED_NAME_TEST_IDS = [
        116,
    ];

    /**
     * Get the condensed result for a student and test.
     */
    public function result(
        int $testId,
        Student $student,
    ): mixed {
        if (
            in_array(
                $testId,
                self::MAX_NAME_VALUE_TEST_IDS,
                true,
            )
        ) {
            return $this->maxNameValueResult(
                testId: $testId,
                student: $student,
            );
        }

        if (
            in_array(
                $testId,
                self::AVERAGE_PERCENTAGE_TEST_IDS,
                true,
            )
        ) {
            return $this->averagePercentageResult(
                testId: $testId,
                student: $student,
            );
        }

        if (
            in_array(
                $testId,
                self::MERGED_NAME_TEST_IDS,
                true,
            )
        ) {
            return $this->mergedNamesResult(
                testId: $testId,
                student: $student,
            );
        }

        return $this->legacyResult(
            testId: $testId,
            student: $student,
        );
    }

    /**
     * Get the detailed result for a student and test.
     */
    public function detailedResult(
        int $testId,
        Student $student,
    ): mixed {
        return $this->legacy(
            testId: $testId,
            student: $student,
        )->detailedResult;
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
     * Fall back to the legacy condensed result.
     */
    private function legacyResult(
        int $testId,
        Student $student,
    ): mixed {
        return $this->legacy(
            testId: $testId,
            student: $student,
        )->result;
    }

    /**
     * Build the legacy result handler.
     */
    private function legacy(
        int $testId,
        Student $student,
    ): StudentTestResult {
        return new StudentTestResult(
            $testId,
            $student->id,
        );
    }
}
