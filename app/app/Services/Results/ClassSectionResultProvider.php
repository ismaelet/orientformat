<?php

namespace App\Services\Results;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use Illuminate\Support\Facades\Cache;

class ClassSectionResultProvider {
    public function __construct(
        private SectionGroupResultCalculator $resultCalculator,
    ) {
    }

    /**
     * Get aggregated results for a section and school class.
     */
    public function get(
        Section $section,
        SchoolClass $class,
    ): array {
        return Cache::remember(
            key: $this->cacheKey(
                section: $section,
                class: $class,
            ),
            ttl: now()->addMinutes(30),
            callback: fn() => $this->resultCalculator
                ->forSchoolClass(
                    section: $section,
                    class: $class,
                ),
        );
    }

    /**
     * Forget the cached result.
     */
    public function forget(
        Section $section,
        SchoolClass $class,
    ): void {
        Cache::forget(
            $this->cacheKey(
                section: $section,
                class: $class,
            ),
        );
    }

    /**
     * Generate the cache key.
     */
    private function cacheKey(
        Section $section,
        SchoolClass $class,
    ): string {
        return implode(':', [
            'school-class',
            $class->id,
            'section',
            $section->id,
            'result',
        ]);
    }
}
