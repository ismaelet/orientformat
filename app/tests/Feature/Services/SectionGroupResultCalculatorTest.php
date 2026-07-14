<?php

namespace Tests\Feature\Services;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Services\Results\SectionGroupResultCalculator;
use RuntimeException;
use Tests\TestCase;

class SectionGroupResultCalculatorTest extends TestCase {
    public function test_class_named_percentage_result_has_expected_shape(): void {
        $section = Section::findOrFail(8);
        $class = SchoolClass::query()->firstOrFail();

        $result = app(
            SectionGroupResultCalculator::class,
        )->forSchoolClass(
            section: $section,
            class: $class,
        );

        $this->assertArrayHasKey('values', $result);
        $this->assertArrayHasKey('count', $result);
        $this->assertIsArray($result['values']);
        $this->assertIsInt($result['count']);
    }

    public function test_class_tier_result_has_expected_shape(): void {
        $section = Section::findOrFail(9);
        $class = SchoolClass::query()->firstOrFail();

        $result = app(
            SectionGroupResultCalculator::class,
        )->forSchoolClass(
            section: $section,
            class: $class,
        );

        $this->assertArrayHasKey('values', $result);
        $this->assertArrayHasKey('count', $result);

        foreach ($result['values'] as $value) {
            $this->assertIsNumeric($value);
        }
    }

    public function test_platform_result_has_expected_shape(): void {
        $section = Section::findOrFail(8);

        $result = app(
            SectionGroupResultCalculator::class,
        )->forPlatform(
            section: $section,
        );

        $this->assertArrayHasKey('values', $result);
        $this->assertArrayHasKey('count', $result);
        $this->assertIsArray($result['values']);
        $this->assertIsInt($result['count']);
    }

    public function test_unsupported_section_throws_exception(): void {
        $section = new Section();
        $section->id = 9999;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Unsupported graph section [9999].',
        );

        app(
            SectionGroupResultCalculator::class,
        )->forPlatform(
            section: $section,
        );
    }

    public function test_temperament_class_result_is_calculated_correctly(): void {
        $result = app(
            SectionGroupResultCalculator::class,
        )->forSchoolClass(
            section: Section::findOrFail(8),
            class: SchoolClass::findOrFail(123),
        );

        $this->assertSame(
            [
                'values' => [
                    'Trait name 1' => 54,
                    'Trait name 2' => 61,
                ],
                'count' => 23,
            ],
            $result,
        );
    }

    public function test_tier_percentages_total_approximately_one_hundred(): void {
        $result = app(
            SectionGroupResultCalculator::class,
        )->forPlatform(
            section: Section::findOrFail(9),
        );

        $this->assertEqualsWithDelta(
            100,
            array_sum($result['values']),
            1,
        );
    }

    public function test_empty_class_returns_empty_graph_result(): void {
        $class = SchoolClass::factory()->create();

        $result = app(
            SectionGroupResultCalculator::class,
        )->forSchoolClass(
            section: Section::findOrFail(8),
            class: $class,
        );

        $this->assertSame(
            [
                'values' => [],
                'count' => 0,
            ],
            $result,
        );
    }
}
