<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use App\Support\Graphs\GraphSections;
use App\Support\Graphs\SectionGraphDefinition;
use Illuminate\Support\Facades\Cache;

class PlatformSectionResultProvider
{
    public function __construct(
        private SectionGroupResultCalculator $resultCalculator,
    ) {}

    /**
     * Get aggregated platform results for a section.
     */
    public function get(
        Section $section,
    ): array {
        return $this->getForGraph(
            GraphSections::graphDefinitionForSection(
                $section,
            ),
        );
    }

    public function getForGraph(
        SectionGraphDefinition $graph,
    ): array {
        return Cache::remember(
            key: $this->cacheKeyForGraph($graph),
            ttl: now()->addMinutes(30),
            callback: fn (): array => $this->resultCalculator
                ->forPlatformGraph($graph),
        );
    }

    private function cacheKeyForGraph(
        SectionGraphDefinition $graph,
    ): string {
        return implode(':', [
            'platform-section-result',
            'v3',
            $graph->section->id,
            $graph->key,
        ]);
    }

    public function forget(
        Section $section,
    ): void {
        foreach (
            GraphSections::graphDefinitionsForSection(
                $section,
            ) as $graph
        ) {
            $this->forgetForGraph($graph);
        }
    }

    public function forgetForGraph(
        SectionGraphDefinition $graph,
    ): void {
        Cache::forget(
            $this->cacheKeyForGraph($graph),
        );
    }
}
