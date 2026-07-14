<?php

namespace App\Services\Results;

use App\Helpers\Tests\RuotaHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Support\GraphSections;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SectionGroupResultCalculator {

    public function __construct(
        private StudentSectionResultCalculator $studentSectionResults,
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
        return match (GraphSections::typeForSection($section->id)) {
            GraphSections::TYPE_NAMED_PERCENTAGE,
            GraphSections::TYPE_FIXED_SCORE =>
            $this->calculatePlatformNamedPercentages(
                section: $section,
            ),

            GraphSections::TYPE_TIER =>
            $this->calculatePlatformTierResults(
                section: $section,
            ),
        };
    }

    /**
     * Calculate the aggregated result for the given students
     */
    private function calculatePlatformNamedPercentages(
        Section $section,
    ): array {
        $values = $this->initialNamedPercentageValues(
            section: $section,
        );

        $count = 0;

        $this->platformStudentsQuery($section)
            ->chunkById(
                500,
                function (Collection $students) use (
                    $section,
                    &$values,
                    &$count,
                ): void {
                    $this->studentSectionResults
                        ->clearPreloadedResults();

                    $this->accumulateNamedPercentages(
                        section: $section,
                        students: $students,
                        values: $values,
                        count: $count,
                    );
                },
                column: 'id',
            );

        return $this->finalizeNamedPercentages(
            values: $values,
            count: $count,
        );
    }

    /**
     * This method returns a query builder for students who have completed the given section. It is used to calculate aggregated results for the whole platform
     */
    private function platformStudentsQuery(
        Section $section,
    ): Builder {
        return Student::query()
            ->whereHas(
                'section_results',
                fn($query) => $query
                    ->where('sectionId', $section->id)
                    ->where('completed', true),
            );
    }

    /**
     * Calculate the aggregated result for the given students.
     */
    private function calculate(
        Section $section,
        Collection $students,
    ): array {
        return match (GraphSections::typeForSection($section->id)) {
            GraphSections::TYPE_NAMED_PERCENTAGE,
            GraphSections::TYPE_FIXED_SCORE =>
            $this->calculateNamedPercentages(
                section: $section,
                students: $students,
            ),

            GraphSections::TYPE_TIER =>
            $this->calculateTierResults(
                section: $section,
                students: $students,
            ),
        };
    }

    /**
     * Create the initial values for a named-percentage graph
     *
     * The Ruota delle emozioni graph must always contain every emotion,
     * including emotions whose aggregated value is zero.
     */
    private function initialNamedPercentageValues(
        Section $section,
    ): array {
        if ($section->id !== 27) {
            return [];
        }

        $test = Test::findOrFail(116);

        return array_fill_keys(
            array_map(
                fn($emotion) => ucfirst($emotion),
                RuotaHelper::emotions($test),
            ),
            0,
        );
    }

    /**
     * Add students to a named-percentage aggregation.
     */
    private function accumulateNamedPercentages(
        Section $section,
        Collection $students,
        array &$values,
        int &$count,
    ): void {
        $this->studentSectionResults->preloadResults(
            section: $section,
            students: $students,
        );

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
    }

    /**
     * Calculate the aggregated result for the given students
     */
    private function finalizeNamedPercentages(
        array $values,
        int $count,
    ): array {
        if ($count === 0) {
            return [
                'values' => $values,
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
     * Add students to a tier aggregation
     */
    private function accumulateTierResults(
        Section $section,
        Collection $students,
        array &$tierCounts,
        int &$count,
        float &$percentageTotal,
    ): void {
        $this->studentSectionResults->preloadResults(
            section: $section,
            students: $students,
        );

        foreach ($students as $student) {
            $result = $this->studentSectionResults->result(
                section: $section,
                student: $student,
            );

            if (!$result) {
                continue;
            }

            $percentage = (float) rtrim(
                (string) $result,
                '%',
            );

            $count++;
            $percentageTotal += $percentage;

            $tierIndex = (int) floor(
                min($percentage, 99) / 25,
            );

            $tierName = array_keys(
                $tierCounts,
            )[$tierIndex];

            $tierCounts[$tierName]++;
        }
    }

    /**
     * Calculate the aggregated result for the given students
     */
    private function emptyTierCounts(): array {
        return [
            'Basso' => 0,
            'Medio' => 0,
            'Alto' => 0,
            'Molto alto' => 0,
        ];
    }

    /**
     * Finalize the tier aggregation
     */
    private function finalizeTierResults(
        array $tierCounts,
        int $count,
        float $percentageTotal,
    ): array {
        if ($count === 0) {
            return [
                'values' => [],
                'counts' => $tierCounts,
                'count' => 0,
                'average' => null,
            ];
        }

        $percentages = [];

        foreach ($tierCounts as $tierName => $tierCount) {
            $percentages[$tierName] = percent(
                $tierCount,
                $count,
            );
        }

        return [
            'values' => $percentages,
            'counts' => $tierCounts,
            'count' => $count,
            'average' => round(
                $percentageTotal / $count,
            ),
        ];
    }

    /**
     * Calculate average named percentages
     */
    private function calculateNamedPercentages(
        Section $section,
        Collection $students,
    ): array {
        $values = $this->initialNamedPercentageValues(
            section: $section,
        );

        $count = 0;

        $this->accumulateNamedPercentages(
            section: $section,
            students: $students,
            values: $values,
            count: $count,
        );

        return $this->finalizeNamedPercentages(
            values: $values,
            count: $count,
        );
    }

    /**
     * Calculate the aggregated result for the given students
     */
    private function calculatePlatformTierResults(
        Section $section,
    ): array {
        $tierCounts = $this->emptyTierCounts();
        $count = 0;
        $percentageTotal = 0.0;

        $this->platformStudentsQuery($section)
            ->chunkById(
                500,
                function (Collection $students) use (
                    $section,
                    &$tierCounts,
                    &$count,
                    &$percentageTotal,
                ): void {
                    $this->studentSectionResults
                        ->clearPreloadedResults();

                    $this->accumulateTierResults(
                        section: $section,
                        students: $students,
                        tierCounts: $tierCounts,
                        count: $count,
                        percentageTotal: $percentageTotal,
                    );
                },
                column: 'id',
            );

        return $this->finalizeTierResults(
            tierCounts: $tierCounts,
            count: $count,
            percentageTotal: $percentageTotal,
        );
    }

    /**
     * Calculate tier percentages
     */
    private function calculateTierResults(
        Section $section,
        Collection $students,
    ): array {
        $tierCounts = $this->emptyTierCounts();
        $count = 0;
        $percentageTotal = 0.0;

        $this->accumulateTierResults(
            section: $section,
            students: $students,
            tierCounts: $tierCounts,
            count: $count,
            percentageTotal: $percentageTotal,
        );

        return $this->finalizeTierResults(
            tierCounts: $tierCounts,
            count: $count,
            percentageTotal: $percentageTotal,
        );
    }
}
