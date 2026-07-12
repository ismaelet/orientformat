<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class SectionGroupResultCalculator {
    /**
     * Sections whose aggregated result consists of named percentages.
     */
    private const NAMED_PERCENTAGE_SECTION_IDS = [
        // Profilo - Stili cognitivi
        1,
        28,
        36,
        37,

        // Profilo - Autostima
        4,
        29,
        41,

        // Profilo - Stile attributivo
        6,

        // Profilo - Motivazione
        7,

        // Profilo - Temperamento
        8,

        // Saperi - Creatività
        17,

        // Scegliere - Interessi
        24,
        45,

        // Profilo - La ruota delle emozioni
        27,
    ];

    /**
     * Sections whose aggregated result consists of tiers.
     */
    private const TIER_SECTION_IDS = [
        // Profilo - Resilienza
        3,

        // Profilo - Risolvere i problemi
        5,
        30,

        // Competenze - Stare attenti
        9,
        31,

        // Competenze - Ricordare
        10,
        32,

        // Competenze - Ascoltare
        11,
        33,

        // Competenze - Parlare
        12,

        // Competenze - Scrivere
        14,
        34,

        // Competenze - Leggere
        39,

        // Competenze - Imparare
        40,
    ];

    public function __construct(
        private StudentSectionResultCalculator $studentSectionResults,
        private StudentTestResultCalculator $studentTestResults,
    ) {
    }

    /**
     * Calculate aggregated results for a school class.
     */
    public function forSchoolClass(
        Section $section,
        SchoolClass $class,
    ): array {
        $students = Student::query()
            ->where('schoolClassId', $class->id)
            ->get();

        return $this->calculate(
            section: $section,
            students: $students,
        );
    }

    /**
     * Calculate aggregated results for the whole platform.
     */
    public function forPlatform(
        Section $section,
    ): array {
        $students = Student::query()
            ->whereHas(
                'section_results',
                fn($query) => $query
                    ->where('sectionId', $section->id)
                    ->where('completed', true),
            )
            ->get();

        return $this->calculate(
            section: $section,
            students: $students,
        );
    }

    /**
     * Calculate the aggregated result for the given students.
     */
    private function calculate(
        Section $section,
        Collection $students,
    ): array {
        $testIds = $this->studentSectionResults
            ->requiredTestIds($section);

        $expandedTestIds = $this->studentTestResults
            ->expandRequiredTestIds($testIds);

        $this->studentTestResults
            ->preloadCompletedResults(
                students: $students,
                testIds: $expandedTestIds,
            );

        if (
            in_array(
                $section->id,
                self::NAMED_PERCENTAGE_SECTION_IDS,
                true,
            )
        ) {
            return $this->calculateNamedPercentages(
                section: $section,
                students: $students,
            );
        }

        if (
            in_array(
                $section->id,
                self::TIER_SECTION_IDS,
                true,
            )
        ) {
            return $this->calculateTierResults(
                section: $section,
                students: $students,
            );
        }

        throw new RuntimeException(
            "Unsupported graph section [{$section->id}].",
        );
    }

    /**
     * Calculate average named percentages.
     */
    private function calculateNamedPercentages(
        Section $section,
        Collection $students,
    ): array {
        $values = [];
        $count = 0;

        foreach ($students as $student) {
            $studentResult = $this->studentSectionResults
                ->detailedResult(
                    section: $section,
                    student: $student,
                );

            if (empty($studentResult)) {
                continue;
            }

            $count++;

            foreach ($studentResult as $resultData) {
                $name = $resultData['name'];
                $percentage = $resultData['percentage'];

                $values[$name] ??= 0;
                $values[$name] += $percentage;
            }
        }

        if ($count === 0) {
            return [
                'values' => [],
                'count' => 0,
            ];
        }

        foreach ($values as &$value) {
            $value = round($value / $count);
        }

        unset($value);

        return [
            'values' => $values,
            'count' => $count,
        ];
    }

    /**
     * Calculate tier percentages.
     */
    private function calculateTierResults(
        Section $section,
        Collection $students,
    ): array {
        $tierCounts = [
            'Basso' => 0,
            'Medio' => 0,
            'Alto' => 0,
            'Molto alto' => 0,
        ];

        $count = 0;

        foreach ($students as $student) {
            $result = $this->studentSectionResults->result(
                section: $section,
                student: $student,
            );

            if (!$result) {
                continue;
            }

            $count++;

            $percentage = (float) rtrim(
                (string) $result,
                '%',
            );

            $tierIndex = (int) floor(
                min($percentage, 99) / 25,
            );

            $tierName = array_keys($tierCounts)[$tierIndex];

            $tierCounts[$tierName]++;
        }

        if ($count === 0) {
            return [
                'values' => [],
                'count' => 0,
            ];
        }

        $values = [];

        foreach ($tierCounts as $tierName => $tierCount) {
            $values[$tierName] = percent(
                $tierCount,
                $count,
            );
        }

        return [
            'values' => $values,
            'count' => $count,
        ];
    }
}
