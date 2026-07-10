<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use Illuminate\Support\Facades\Cache;

class PlatformSectionResultProvider {
    public function __construct(
        private SectionGroupResultCalculator $resultCalculator,
    ) {
    }

    /**
     * Get aggregated platform results for a section.
     */
    public function get(
        Section $section,
    ): array {
        return Cache::remember(
            key: $this->cacheKey($section),
            ttl: now()->addMonth(),
            callback: fn() => $this->resultCalculator
                ->forPlatform($section),
        );
    }

    /**
     * Get the platform result cache key.
     */
    private function cacheKey(
        Section $section,
    ): string {
        return "section:{$section->id}:platform-result";
    }
}
