<?php

namespace App\Support;

final class SectionResultDefinitions {
    /**
     * Main result test for sections calculated from one test.
     *
     * @var array<int, int>
     */
    private const MAIN_TEST_IDS = [
        1 => 31,
        3 => 49,
        4 => 15,
        6 => 48,
        7 => 20,
        8 => 46,
        17 => 81,
        18 => 82,
        24 => 92,
        25 => 100,
        26 => 101,
        27 => 116,
        28 => 109,
        29 => 107,
        36 => 111,
        37 => 113,
        41 => 146,
        45 => 151,
    ];

    /**
     * Test IDs excluded from detailed full-section results.
     *
     * Presence in this map means the section uses full-section results,
     * even when the skip list is empty.
     *
     * @var array<int, array<int>>
     */
    private const FULL_SECTION_SKIPPED_TEST_IDS = [
        5 => [94, 119, 147, 162],
        30 => [94, 119, 147, 162],
        38 => [94, 119, 147, 162],
        42 => [94, 119, 147, 162],

        10 => [56],
        32 => [56],
        49 => [56],

        11 => [],
        33 => [],
        47 => [],
        48 => [],

        12 => [],
        50 => [],

        13 => [70],
        39 => [70],
        53 => [70],
        54 => [70],

        14 => [62, 63, 167, 168],
        34 => [62, 63, 167, 168],
        51 => [62, 63, 167, 168],
        55 => [62, 63, 167, 168],
        57 => [62, 63, 167, 168],

        15 => [131],
        40 => [131],
        56 => [131],

        31 => [],
    ];

    public static function mainTestId(int $sectionId): ?int {
        return self::MAIN_TEST_IDS[$sectionId] ?? null;
    }

    public static function usesFullSectionResults(
        int $sectionId,
    ): bool {
        return array_key_exists(
            $sectionId,
            self::FULL_SECTION_SKIPPED_TEST_IDS,
        );
    }

    /**
     * @return array<int>
     */
    public static function skippedTestIds(
        int $sectionId,
    ): array {
        return self::FULL_SECTION_SKIPPED_TEST_IDS[$sectionId] ?? [];
    }

    /**
     * @return array<int>
     */
    public static function supportedSectionIds(): array {
        return array_values(
            array_unique([
                ...array_keys(self::MAIN_TEST_IDS),
                ...array_keys(
                    self::FULL_SECTION_SKIPPED_TEST_IDS,
                ),
                9,
            ]),
        );
    }
}
