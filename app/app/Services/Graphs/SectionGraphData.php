<?php

namespace App\Services\Graphs;

use App\Helpers\Tests\ProblemiSuperioriProblemGruppoHelper;
use App\Helpers\Tests\RuotaHelper;
use App\Helpers\Tests\ScrivereSemplificatoMappaHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Support\Graphs\SectionGraphDefinition;
use App\Support\Graphs\GraphSections;

class SectionGraphData {

    private const RUOTA_SECTION_ID = 27;
    private const RUOTA_TEST_ID = 116;
    private const SCRIVERE_SEMPLIFICATO_SECTION_ID = 34;

    /**
     * Prepare one aggregated section result for graph display.
     */
    public function build(
        Section $section,
        array $result,
    ): ?array {
        return $this->buildForGraph(
            graph: GraphSections::graphDefinitionForSection(
                $section,
            ),
            result: $result,
        );
    }

    public function buildForGraph(
        SectionGraphDefinition $graph,
        array $result,
    ): ?array {
        $section = $graph->section;

        $values = $result['values'] ?? [];

        if (empty($values)) {
            return null;
        }

        $labels = $this->labelsForGraph(
            graph: $graph,
            values: $values,
        );

        $alignedValues = $this->alignValues(
            labels: $labels,
            values: $values,
        );

        $graphValues = $this->normalizeValues(
            section: $section,
            values: $alignedValues,
        );

        $condensed = $this->condensedResult(
            graph: $graph,
            rawValues: $alignedValues,
            graphValues: $graphValues,
            studentAverage: $result['average'] ?? null,
        );

        return [
            'key' => $graph->key,

            'labels' => $this->displayLabels(
                section: $section,
                labels: $labels,
            ),

            'data' => $graphValues,

            'condensed_label' =>
            $this->condensedLabelForGraph(
                graph: $graph,
                valueCount: $condensed['count'],
            ),

            'condensed' => $this->displayCondensedValue(
                section: $section,
                value: $condensed['value'],
            ),

            'description' =>
            $graph->description
                ?? GraphSections::descriptionForSection(
                    $section->id,
                ),
        ];
    }

    /**
     * Prepare class and platform results for comparison.
     */
    public function buildComparison(
        Section $section,
        array $schoolClassResult,
        array $platformResult,
    ): ?array {
        return $this->buildComparisonForGraph(
            graph: GraphSections::graphDefinitionForSection(
                $section,
            ),
            schoolClassResult: $schoolClassResult,
            platformResult: $platformResult,
        );
    }

    public function buildComparisonForGraph(
        SectionGraphDefinition $graph,
        array $schoolClassResult,
        array $platformResult,
    ): ?array {
        $section = $graph->section;

        $schoolClassValues =
            $schoolClassResult['values'] ?? [];

        if (empty($schoolClassValues)) {
            return null;
        }

        $platformValues =
            $platformResult['values'] ?? [];

        $labels = $this->labelsForGraph(
            graph: $graph,
            values: $schoolClassValues,
        );

        $alignedSchoolClassValues = $this->alignValues(
            labels: $labels,
            values: $schoolClassValues,
        );

        $alignedPlatformValues = $this->alignValues(
            labels: $labels,
            values: $platformValues,
        );

        $schoolClassGraphValues =
            $this->normalizeValues(
                section: $section,
                values: $alignedSchoolClassValues,
            );

        $platformGraphValues =
            $this->normalizeValues(
                section: $section,
                values: $alignedPlatformValues,
            );

        $condensed = $this->condensedResult(
            graph: $graph,
            rawValues: $alignedSchoolClassValues,
            graphValues: $schoolClassGraphValues,
            studentAverage: $schoolClassResult['average'] ?? null,
        );

        $graphData = [
            'key' => $graph->key,

            'description' =>
            $graph->description
                ?? GraphSections::descriptionForSection(
                    $section->id,
                ),

            'labels' => $this->displayLabels(
                section: $section,
                labels: $labels,
            ),

            'datasets' => [
                'school_class' =>
                $schoolClassGraphValues,

                'platform' =>
                $platformGraphValues,
            ],

            'condensed_label' =>
            $this->condensedLabelForGraph(
                graph: $graph,
                valueCount: $condensed['count'],
            ),

            'condensed' => $this->displayCondensedValue(
                section: $section,
                value: $condensed['value'],
            ),

            'dataset_labels' => [
                'school_class' =>
                $graph->schoolClassDatasetLabel
                    ?? 'Risultato della classe',

                'platform' =>
                $graph->platformDatasetLabel
                    ?? 'Risultato della piattaforma',
            ],
        ];

        if ($graph->type === GraphSections::TYPE_TIER) {
            $graphData['tooltip_values'] = [
                'school_class' => array_values(
                    $this->alignValues(
                        labels: $labels,
                        values: $schoolClassResult['counts']
                            ?? [],
                    ),
                ),
            ];
        }

        return $graphData;
    }

    /**
     * Normalize result values for graph display.
     */
    private function normalizeValues(
        Section $section,
        array $values,
    ): array {
        if (
            GraphSections::normalizationForSection(
                $section->id,
            ) !== GraphSections::NORMALIZATION_TIER_PERCENTAGE
        ) {
            return array_values($values);
        }

        $total = array_sum($values);

        if ($total <= 0) {
            return array_fill(
                0,
                count($values),
                0,
            );
        }

        return array_map(
            fn($value) => round(
                $value / $total * 100,
            ),
            array_values($values),
        );
    }

    /**
     * Align values to a given label order.
     */
    private function alignValues(
        array $labels,
        array $values,
    ): array {
        $alignedValues = [];

        foreach ($labels as $label) {
            $alignedValues[$label] =
                $values[$label] ?? 0;
        }

        return $alignedValues;
    }

    /**
     * Generate the condensed graph result and its item count.
     */
    private function condensedResult(
        SectionGraphDefinition $graph,
        array $rawValues,
        array $graphValues,
        int|float|null $studentAverage,
    ): array {
        $condensedType =
            $graph->condensedType
            ?? GraphSections::condensedTypeForSection(
                $graph->section->id,
            );

        return match ($condensedType) {
            GraphSections::CONDENSED_AVERAGE => [
                'value' => $this->averagePercentage(
                    $graphValues,
                ),
                'count' => 1,
            ],

            GraphSections::CONDENSED_STUDENT_AVERAGE => [
                'value' => $studentAverage === null
                    ? null
                    : round($studentAverage) . '%',
                'count' => 1,
            ],

            GraphSections::CONDENSED_MAX =>
            $this->maxLabelsResult(
                $rawValues,
            ),
        };
    }

    private function condensedLabelForGraph(
        SectionGraphDefinition $graph,
        int $valueCount,
    ): string {
        if (
            $valueCount > 1
            && $graph->condensedPluralLabel !== null
        ) {
            return $graph->condensedPluralLabel;
        }

        if ($graph->condensedLabel !== null) {
            return $graph->condensedLabel;
        }

        return GraphSections::condensedLabelForSection(
            sectionId: $graph->section->id,
            valueCount: $valueCount,
        );
    }

    /**
     * Get all labels associated with the maximum value.
     *
     * @return array{
     *     value: ?string,
     *     count: int
     * }
     */
    private function maxLabelsResult(
        array $values,
    ): array {
        if (empty($values)) {
            return [
                'value' => null,
                'count' => 0,
            ];
        }

        $maximum = max($values);

        if ((float) $maximum <= 0) {
            return [
                'value' => null,
                'count' => 0,
            ];
        }

        $labels = [];

        foreach ($values as $label => $value) {
            if ((float) $value === (float) $maximum) {
                $labels[] = (string) $label;
            }
        }

        return [
            'value' => $this->formatLabelList($labels),
            'count' => count($labels),
        ];
    }

    /**
     * Format labels as an Italian-language list.
     */
    private function formatLabelList(
        array $labels,
    ): ?string {
        $labels = array_values($labels);

        return match (count($labels)) {
            0 => null,
            1 => $labels[0],
            2 => implode(' e ', $labels),
            default => sprintf(
                '%s e %s',
                implode(
                    ', ',
                    array_slice($labels, 0, -1),
                ),
                $labels[array_key_last($labels)],
            ),
        };
    }

    /**
     * Get the average graph percentage.
     */
    private function averagePercentage(
        array $values,
    ): string {
        if (empty($values)) {
            return '0%';
        }

        return percent(
            array_sum($values),
            count($values) * 100,
        ) . '%';
    }

    /**
     * Generate the labels for a section, with special handling for the RUOTA section
     */
    private function labelsForGraph(
        SectionGraphDefinition $graph,
        array $values,
    ): array {
        $section = $graph->section;

        if (
            $graph->key
            === GraphSections::DISTRAIBILITA_IPERATTIVITA_GRAPH_KEY
        ) {
            return [
                'Distraibilità',
                'Iperattività',
            ];
        }

        if (
            $graph->key
            === GraphSections::PROBLEMI_GRUPPO_GRAPH_KEY
        ) {
            return array_values(
                ProblemiSuperioriProblemGruppoHelper::roles(),
            );
        }

        if ($section->id === self::RUOTA_SECTION_ID) {
            return RuotaHelper::emotions(
                Test::findOrFail(self::RUOTA_TEST_ID),
            );
        }

        if (
            $section->id
            === self::SCRIVERE_SEMPLIFICATO_SECTION_ID
        ) {
            return app(
                ScrivereSemplificatoMappaHelper::class,
            )->getTypes();
        }

        return array_keys($values);
    }

    /**
     * Display labels for a section, with special handling for the RUOTA section
     */
    private function displayLabels(
        Section $section,
        array $labels,
    ): array {
        if ($section->id !== self::RUOTA_SECTION_ID) {
            return $labels;
        }

        return array_map(
            static fn(string $label): string =>
            ucfirst($label),
            $labels,
        );
    }

    /**
     * Display a condensed value for a section, with special handling for the RUOTA section
     */
    private function displayCondensedValue(
        Section $section,
        string|int|float|null $value,
    ): string|int|float|null {
        if (
            $section->id !== self::RUOTA_SECTION_ID
            || !is_string($value)
        ) {
            return $value;
        }

        return mb_strtoupper(
            mb_substr($value, 0, 1),
        ) . mb_substr($value, 1);
    }
}
