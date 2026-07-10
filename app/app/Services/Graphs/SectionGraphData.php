<?php

namespace App\Services\Graphs;

use App\Models\Activities\Section;

class SectionGraphData {
    /**
     * Prepare one aggregated section result for graph display.
     */
    public function build(
        Section $section,
        array $result,
    ): ?array {
        $values = $result['values'] ?? [];

        if (empty($values)) {
            return null;
        }

        $graphValues = $this->normalizeValues(
            section: $section,
            values: $values,
        );

        return [
            'labels' => array_keys($values),

            'data' => $graphValues,

            'condensed' => $this->condensedValue(
                section: $section,
                rawValues: $values,
                graphValues: $graphValues,
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
        $schoolClassValues =
            $schoolClassResult['values'] ?? [];

        if (empty($schoolClassValues)) {
            return null;
        }

        $platformValues =
            $platformResult['values'] ?? [];

        $labels = array_keys($schoolClassValues);

        $alignedPlatformValues = $this->alignValues(
            labels: $labels,
            values: $platformValues,
        );

        $schoolClassGraphValues =
            $this->normalizeValues(
                section: $section,
                values: $schoolClassValues,
            );

        $platformGraphValues =
            $this->normalizeValues(
                section: $section,
                values: $alignedPlatformValues,
            );

        return [
            'labels' => $labels,

            'datasets' => [
                'school_class' =>
                $schoolClassGraphValues,

                'platform' =>
                $platformGraphValues,
            ],

            'condensed' => $this->condensedValue(
                section: $section,
                rawValues: $schoolClassValues,
                graphValues: $schoolClassGraphValues,
            ),
        ];
    }

    /**
     * Normalize result values for graph display.
     */
    private function normalizeValues(
        Section $section,
        array $values,
    ): array {
        if (
            section_config(
                $section->id,
                'type',
            ) !== 'tiers'
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
     * Generate the condensed graph result.
     */
    private function condensedValue(
        Section $section,
        array $rawValues,
        array $graphValues,
    ): string|int|float|null {
        return match (section_config(
            $section->id,
            'condensedType',
        )) {
            'max' => $this->maxLabel(
                $rawValues,
            ),

            'average' => $this->averagePercentage(
                $graphValues,
            ),

            default => null,
        };
    }

    /**
     * Get the label associated with the maximum value.
     */
    private function maxLabel(
        array $values,
    ): ?string {
        if (empty($values)) {
            return null;
        }

        $maximum = max($values);

        foreach ($values as $label => $value) {
            if ($value === $maximum) {
                return (string) $label;
            }
        }

        return null;
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
}
