<?php

namespace App\Services\Results;

use App\Helpers\TestResultHelper;
use App\Models\Activities\Section;
use App\Models\User\Student;
use Legacy\Activity\Result\Handler\StudentSectionResult;

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
        27 => 116,
    ];

    public function __construct(
        private StudentTestResultCalculator $studentTestResults,
    ) {
    }

    /**
     * Get the condensed result for a student and section.
     */
    public function result(
        Section $section,
        Student $student,
    ): ?string {
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
        return $this->legacy(
            section: $section,
            student: $student,
        )->detailedResult;
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
    ): ?string {
        $testId = self::MAIN_TEST_IDS[$section->id] ?? null;

        if ($testId === null) {
            return $this->legacyResult(
                section: $section,
                student: $student,
            );
        }

        if ($testId === 116) {
            return TestResultHelper::getResult(
                $student->id,
                $testId,
            );
        }

        return $this->studentTestResults->result(
            testId: $testId,
            student: $student,
        );
    }

    /**
     * Fall back to the legacy condensed result.
     */
    private function legacyResult(
        Section $section,
        Student $student,
    ): ?string {
        return $this->legacy(
            section: $section,
            student: $student,
        )->result;
    }

    /**
     * Build the legacy result handler.
     */
    private function legacy(
        Section $section,
        Student $student,
    ): StudentSectionResult {
        return new StudentSectionResult(
            $section->id,
            $student->id,
        );
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
}
