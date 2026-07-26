<?php

namespace App\Support\Graphs;

use App\Models\Activities\Section;

final readonly class SectionGraphDefinition {
    /**
     * @param array<int>|null $testIds
     */
    public function __construct(
        public Section $section,
        public string $key,
        public string $type,
        public ?array $testIds = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $schoolClassDatasetLabel = null,
        public ?string $platformDatasetLabel = null,
        public ?string $condensedType = null,
        public ?string $condensedLabel = null,
        public ?string $condensedPluralLabel = null,
    ) {
    }

    public static function fromArray(
        Section $section,
        array $config,
    ): self {
        return new self(
            section: $section,
            key: $config['key'],
            type: $config['type'],
            testIds: $config['test_ids'] ?? null,
            title: $config['title'] ?? null,
            description: $config['description'] ?? null,

            schoolClassDatasetLabel: $config['school_class_dataset_label'] ?? null,

            platformDatasetLabel: $config['platform_dataset_label'] ?? null,

            condensedType: $config['condensed_type'] ?? null,

            condensedLabel: $config['condensed_label'] ?? null,

            condensedPluralLabel: $config['condensed_plural_label'] ?? null,
        );
    }

    public function displayTitle(): string {
        return $this->title ?? $this->section->name;
    }
}
