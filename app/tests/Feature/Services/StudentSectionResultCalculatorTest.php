<?php

use App\Models\Activities\Section;
use App\Models\User\Student;
use App\Services\Results\StudentSectionResultCalculator;

test('it calculates graph section results', function (int $sectionId): void {
    $student = Student::query()
        ->whereHas(
            'section_results',
            fn ($query) => $query
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

    expect($result === null
            || is_string($result)
            || is_array($result))->toBeTrue();
})->with([1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 17, 24, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 39, 40, 41, 45]);

test('it calculates the attention result', function (): void {
    $student = Student::findOrFail(123);
    $section = Section::findOrFail(9);

    $result = app(
        StudentSectionResultCalculator::class,
    )->result(
        section: $section,
        student: $student,
    );

    expect($result)->toBe('67%');
});

test('it rejects unsupported sections', function (): void {
    $student = Student::factory()->create();
    $section = Section::factory()->create([
        'id' => 9999,
    ]);

    expect(fn () => app(StudentSectionResultCalculator::class)->result(section: $section, student: $student))
        ->toThrow(RuntimeException::class, 'Unsupported condensed result section [9999].');
});
