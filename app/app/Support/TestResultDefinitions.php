<?php

namespace App\Support;

use RuntimeException;

final class TestResultDefinitions {
    public const RESULT_MAX_NAME_VALUE = 'max_name_value';
    public const RESULT_AVERAGE_PERCENTAGE = 'average_percentage';
    public const RESULT_GENERIC = 'generic';
    public const RESULT_MERGED_NAMES = 'merged_names';
    public const RESULT_DETAILED = 'detailed';
    public const RESULT_COMPLETED = 'completed';

    public const DETAIL_ATTENTION_SELF_EVALUATION =
    'attention_self_evaluation';

    public const DETAIL_MOTIVATION = 'motivation';
    public const DETAIL_ATTENTION_HYPERACTIVITY =
    'attention_hyperactivity';

    public const DETAIL_COGNITIVE_STYLE = 'cognitive_style';
    public const DETAIL_TEMPERAMENT = 'temperament';
    public const DETAIL_ATTRIBUTION_STYLE = 'attribution_style';
    public const DETAIL_GENERIC = 'generic';
    public const DETAIL_TESTS_AVERAGE = 'tests_average';
    public const DETAIL_INTERESTS = 'interests';
    public const DETAIL_LIFE_TREE = 'life_tree';
    public const DETAIL_EMOTION_WHEEL = 'emotion_wheel';

    /**
     * Condensed-result calculation type for each test.
     *
     * @var array<int, string>
     */
    private const RESULT_TYPES = [
        // Highest named detailed value
        20 => self::RESULT_MAX_NAME_VALUE,
        31 => self::RESULT_MAX_NAME_VALUE,
        46 => self::RESULT_MAX_NAME_VALUE,
        48 => self::RESULT_MAX_NAME_VALUE,
        92 => self::RESULT_MAX_NAME_VALUE,
        109 => self::RESULT_MAX_NAME_VALUE,
        111 => self::RESULT_MAX_NAME_VALUE,
        113 => self::RESULT_MAX_NAME_VALUE,
        151 => self::RESULT_MAX_NAME_VALUE,

        // Average detailed percentage
        15 => self::RESULT_AVERAGE_PERCENTAGE,
        63 => self::RESULT_AVERAGE_PERCENTAGE,
        81 => self::RESULT_AVERAGE_PERCENTAGE,
        107 => self::RESULT_AVERAGE_PERCENTAGE,
        146 => self::RESULT_AVERAGE_PERCENTAGE,
        168 => self::RESULT_AVERAGE_PERCENTAGE,

        // Generic percentage
        49 => self::RESULT_GENERIC,

        // Merge detailed names
        116 => self::RESULT_MERGED_NAMES,
        208 => self::RESULT_MERGED_NAMES,

        // Return detailed result directly
        101 => self::RESULT_DETAILED,

        // Completion label
        82 => self::RESULT_COMPLETED,
        100 => self::RESULT_COMPLETED,
    ];

    /**
     * Detailed-result calculation type for each test.
     *
     * @var array<int, string>
     */
    private const DETAILED_TYPES = [
        16 => self::DETAIL_ATTENTION_SELF_EVALUATION,
        20 => self::DETAIL_MOTIVATION,
        21 => self::DETAIL_ATTENTION_HYPERACTIVITY,

        31 => self::DETAIL_COGNITIVE_STYLE,
        109 => self::DETAIL_COGNITIVE_STYLE,
        111 => self::DETAIL_COGNITIVE_STYLE,
        113 => self::DETAIL_COGNITIVE_STYLE,

        46 => self::DETAIL_TEMPERAMENT,
        48 => self::DETAIL_ATTRIBUTION_STYLE,

        49 => self::DETAIL_GENERIC,
        82 => self::DETAIL_GENERIC,
        100 => self::DETAIL_GENERIC,

        15 => self::DETAIL_TESTS_AVERAGE,
        81 => self::DETAIL_TESTS_AVERAGE,
        107 => self::DETAIL_TESTS_AVERAGE,
        146 => self::DETAIL_TESTS_AVERAGE,

        92 => self::DETAIL_INTERESTS,
        151 => self::DETAIL_INTERESTS,

        101 => self::DETAIL_LIFE_TREE,
        116 => self::DETAIL_EMOTION_WHEEL,
        208 => self::DETAIL_EMOTION_WHEEL,
    ];

    public const DEPENDENCY_REQUIRED_TEST = 'required_test';
    public const DEPENDENCY_PREVIOUS_SECTION_TESTS =
    'previous_section_tests';
    public const DEPENDENCY_SECTION_STEPS =
    'section_steps';
    public const DEPENDENCY_FIXED_TESTS =
    'fixed_tests';

    /**
     * Additional tests needed to calculate a test result.
     *
     * @var array<int, array<string, mixed>>
     */
    private const DEPENDENCIES = [
        16 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        20 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        21 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        31 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        48 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        92 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        109 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        111 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        113 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],
        151 => [
            'type' => self::DEPENDENCY_REQUIRED_TEST,
        ],

        // Tests calculated from all preceding tests in the section
        15 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],
        81 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],
        107 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],
        146 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],

        // Temperament: section tests from step 1 to step 5
        46 => [
            'type' => self::DEPENDENCY_SECTION_STEPS,
            'from' => 1,
            'to' => 5,
        ],

        // Emotion wheel
        116 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],

        208 => [
            'type' => self::DEPENDENCY_PREVIOUS_SECTION_TESTS,
        ],
    ];

    public static function resultType(int $testId): string {
        return self::RESULT_TYPES[$testId]
            ?? throw new RuntimeException(
                "Unsupported condensed test result [{$testId}].",
            );
    }

    public static function detailedType(int $testId): string {
        return self::DETAILED_TYPES[$testId]
            ?? throw new RuntimeException(
                "Unsupported detailed test result [{$testId}].",
            );
    }

    public static function supportsResult(int $testId): bool {
        return array_key_exists(
            $testId,
            self::RESULT_TYPES,
        );
    }

    public static function supportsDetailedResult(
        int $testId,
    ): bool {
        return array_key_exists(
            $testId,
            self::DETAILED_TYPES,
        );
    }

    public static function dependency(
        int $testId,
    ): ?array {
        return self::DEPENDENCIES[$testId] ?? null;
    }

    public static function dependencyType(
        int $testId,
    ): ?string {
        return self::DEPENDENCIES[$testId]['type']
            ?? null;
    }
}
