<?php

namespace Tests\Feature\Services;

use App\Models\Activities\Section;
use App\Models\User\Student;
use App\Services\Results\StudentSectionResultCalculator;
use Tests\TestCase;

class StudentSectionResultCalculatorTest extends TestCase {
    /**
     * @dataProvider graphSections
     */
    public function test_it_calculates_graph_section_results(
        int $sectionId,
    ): void {
        $student = Student::query()
            ->whereHas(
                'section_results',
                fn($query) => $query
                    ->where('sectionId', $sectionId)
                    ->where('completed', true),
            )
            ->firstOrFail();

        $section = Section::findOrFail($sectionId);

        $calculator = app(
            StudentSectionResultCalculator::class,
        );

        $result = $calculator->result(
            section: $section,
            student: $student,
        );

        $this->assertTrue(
            $result === null
                || is_string($result)
                || is_array($result),
        );
    }

    public static function graphSections(): array {
        return array_map(
            fn(int $sectionId) => [$sectionId],
            [
                1,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                11,
                12,
                14,
                17,
                24,
                27,
                28,
                29,
                30,
                31,
                32,
                33,
                34,
                36,
                37,
                39,
                40,
                41,
                45,
            ],
        );
    }

    public function test_it_calculates_the_attention_result(): void {
        $student = Student::findOrFail(123);
        $section = Section::findOrFail(9);

        $result = app(
            StudentSectionResultCalculator::class,
        )->result(
            section: $section,
            student: $student,
        );

        $this->assertSame('67%', $result);
    }

    public function test_it_rejects_unsupported_sections(): void {
        $student = Student::factory()->create();
        $section = Section::factory()->create([
            'id' => 9999,
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Unsupported condensed result section [9999].',
        );

        app(
            StudentSectionResultCalculator::class,
        )->result(
            section: $section,
            student: $student,
        );
    }
}
