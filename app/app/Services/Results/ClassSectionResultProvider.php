<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Support\Graphs\GraphSections;
use App\Support\Graphs\SectionGraphDefinition;
use Illuminate\Support\Facades\Cache;

class ClassSectionResultProvider
{
    public function __construct(
        private SectionGroupResultCalculator $resultCalculator,
    ) {}

    /**
     * Get aggregated results for a section and school class.
     */
    public function get(
        Section $section,
        SchoolClass $schoolClass,
    ): array {
        return $this->getForGraph(
            graph: GraphSections::graphDefinitionForSection(
                $section,
            ),
            schoolClass: $schoolClass,
        );
    }

    public function getForGraph(
        SectionGraphDefinition $graph,
        SchoolClass $schoolClass,
    ): array {
        return Cache::remember(
            key: $this->cacheKeyForGraph(
                graph: $graph,
                schoolClass: $schoolClass,
            ),
            ttl: now()->addMinutes(30),
            callback: fn (): array => $this->resultCalculator
                ->forSchoolClassGraph(
                    graph: $graph,
                    schoolClass: $schoolClass,
                ),
        );
    }

    private function cacheKeyForGraph(
        SectionGraphDefinition $graph,
        SchoolClass $schoolClass,
    ): string {
        return implode(':', [
            'class-section-result',
            'v3',
            $schoolClass->id,
            $graph->section->id,
            $graph->key,
        ]);
    }

    public function forget(
        Section $section,
        SchoolClass $schoolClass,
    ): void {
        foreach (
            GraphSections::graphDefinitionsForSection(
                $section,
            ) as $graph
        ) {
            $this->forgetForGraph(
                graph: $graph,
                schoolClass: $schoolClass,
            );
        }
    }

    public function forgetForGraph(
        SectionGraphDefinition $graph,
        SchoolClass $schoolClass,
    ): void {
        Cache::forget(
            $this->cacheKeyForGraph(
                graph: $graph,
                schoolClass: $schoolClass,
            ),
        );
    }
}
