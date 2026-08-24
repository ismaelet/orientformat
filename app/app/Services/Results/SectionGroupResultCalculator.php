<?php

namespace App\Services\Results;

use App\Helpers\Tests\ProblemiSuperioriProblemGruppoHelper;
use App\Helpers\Tests\RuotaHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Support\Graphs\SectionGraphDefinition;
use App\Support\Graphs\GraphSections;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SectionGroupResultCalculator {

    private const RUOTA_SECTION_IDS = [
        27,
        58,
    ];

    public function __construct(
        private StudentSectionResultCalculator $studentSectionResults,
    ) {
    }

    /**
     * Calculate aggregated results for a school class.
     */
    public function forSchoolClass(
        Section $section,
        SchoolClass $schoolClass,
    ): array {
        return $this->forSchoolClassGraph(
            graph: GraphSections::graphDefinitionForSection(
                $section,
            ),
            schoolClass: $schoolClass,
        );
    }

    public function forSchoolClassGraph(
        SectionGraphDefinition $graph,
        SchoolClass $schoolClass,
    ): array {
        $students = $this->studentsForSchoolClass(
            $schoolClass,
        );

        return $this->calculate(
            graph: $graph,
            students: $students,
        );
    }

    /**
     * Calculate aggregated results for the whole platform.
     */
    public function forPlatform(
        Section $section,
    ): array {
        return $this->forPlatformGraph(
            GraphSections::graphDefinitionForSection(
                $section,
            ),
        );
    }

    private function studentsForSchoolClass(
        SchoolClass $schoolClass,
    ): Collection {
        return $schoolClass
            ->students()
            ->get();
    }

    public function forPlatformGraph(
        SectionGraphDefinition $graph,
    ): array {
        return match ($graph->type) {
            GraphSections::TYPE_NAMED_PERCENTAGE,
            GraphSections::TYPE_FIXED_SCORE =>
            $this->calculatePlatformNamedPercentages(
                graph: $graph,
            ),

            GraphSections::TYPE_TIER =>
            $this->calculatePlatformTierResults(
                graph: $graph,
            ),

            default => throw new \LogicException(
                sprintf(
                    'Unsupported graph type [%s] for section [%d].',
                    $graph->type,
                    $graph->section->id,
                ),
            ),
        };
    }

    /**
     * Calculate the aggregated result for the given students
     */
    private function calculatePlatformNamedPercentages(
        SectionGraphDefinition $graph,
    ): array {
        $values = $this->initialNamedPercentageValues(
            graph: $graph,
        );

        $count = 0;

        $this->platformStudentsQuery($graph->section)
            ->chunkById(
                500,
                function (Collection $students) use (
                    $graph,
                    &$values,
                    &$count,
                ): void {
                    $this->studentSectionResults
                        ->clearPreloadedResults();

                    $this->accumulateNamedPercentages(
                        graph: $graph,
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
        SectionGraphDefinition $graph,
        Collection $students,
    ): array {
        return match ($graph->type) {
            GraphSections::TYPE_NAMED_PERCENTAGE,
            GraphSections::TYPE_FIXED_SCORE =>
            $this->calculateNamedPercentages(
                graph: $graph,
                students: $students,
            ),

            GraphSections::TYPE_TIER =>
            $this->calculateTierResults(
                graph: $graph,
                students: $students,
            ),

            default => throw new \LogicException(
                sprintf(
                    'Unsupported graph type [%s] for section [%d].',
                    $graph->type,
                    $graph->section->id,
                ),
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
        SectionGraphDefinition $graph,
    ): array {
        if (
            $graph->key
            === GraphSections::DISTRAIBILITA_IPERATTIVITA_GRAPH_KEY
        ) {
            return [
                'Distraibilità' => 0,
                'Iperattività' => 0,
            ];
        }

        if (
            $graph->key
            === GraphSections::PROBLEMI_GRUPPO_GRAPH_KEY
        ) {
            return array_fill_keys(
                array_values(
                    ProblemiSuperioriProblemGruppoHelper::roles(),
                ),
                0,
            );
        }

        if (
            in_array(
                $graph->section->id,
                self::RUOTA_SECTION_IDS,
                true,
            )
        ) {
            $testId = $graph->testIds[0] ?? null;

            if ($testId === null) {
                return [];
            }

            return array_fill_keys(
                RuotaHelper::emotions(
                    Test::findOrFail($testId),
                ),
                0,
            );
        }

        return [];
    }

    /**
     * Add students to a named-percentage aggregation.
     */
    private function accumulateNamedPercentages(
        SectionGraphDefinition $graph,
        Collection $students,
        array &$values,
        int &$count,
    ): void {
        $this->studentSectionResults->preloadResultsForGraph(
            graph: $graph,
            students: $students,
        );

        $testIds = $graph->testIds;

        if ($testIds !== null) {
            $students->load([
                'test_results' => static fn($query) =>
                $query
                    ->whereIn('testId', $testIds)
                    ->where('completed', true),
            ]);
        }

        foreach ($students as $student) {
            $studentResult = $this->studentSectionResults
                ->detailedResultForGraph(
                    graph: $graph,
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
        SectionGraphDefinition $graph,
        Collection $students,
        array &$tierCounts,
        int &$count,
        float &$percentageTotal,
    ): void {
        $this->studentSectionResults->preloadResultsForGraph(
            graph: $graph,
            students: $students,
        );

        foreach ($students as $student) {
            $result = $this->studentSectionResults
                ->resultForGraph(
                    graph: $graph,
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
        SectionGraphDefinition $graph,
        Collection $students,
    ): array {
        $values = $this->initialNamedPercentageValues(
            graph: $graph,
        );

        $count = 0;

        $this->accumulateNamedPercentages(
            graph: $graph,
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
        SectionGraphDefinition $graph,
    ): array {
        $tierCounts = $this->emptyTierCounts();
        $count = 0;
        $percentageTotal = 0.0;

        $this->platformStudentsQuery($graph->section)
            ->chunkById(
                500,
                function (Collection $students) use (
                    $graph,
                    &$tierCounts,
                    &$count,
                    &$percentageTotal,
                ): void {
                    $this->studentSectionResults
                        ->clearPreloadedResults();

                    $this->accumulateTierResults(
                        graph: $graph,
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
        SectionGraphDefinition $graph,
        Collection $students,
    ): array {
        $tierCounts = $this->emptyTierCounts();
        $count = 0;
        $percentageTotal = 0.0;

        $this->accumulateTierResults(
            graph: $graph,
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
