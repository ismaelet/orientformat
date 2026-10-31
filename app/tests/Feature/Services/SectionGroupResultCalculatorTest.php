<?php

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Services\Results\SectionGroupResultCalculator;

test('class named percentage result has expected shape', function (): void {
    $section = Section::findOrFail(8);
    $class = SchoolClass::query()->firstOrFail();

    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: $section,
        class: $class,
    );

    expect($result)->toHaveKey('values');
    expect($result)->toHaveKey('count');
    expect($result['values'])->toBeArray();
    expect($result['count'])->toBeInt();
});

test('class tier result has expected shape', function (): void {
    $section = Section::findOrFail(9);
    $class = SchoolClass::query()->firstOrFail();

    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: $section,
        class: $class,
    );

    expect($result)->toHaveKey('values');
    expect($result)->toHaveKey('count');

    foreach ($result['values'] as $value) {
        expect($value)->toBeNumeric();
    }
});

test('platform result has expected shape', function (): void {
    $section = Section::findOrFail(8);

    $result = app(
        SectionGroupResultCalculator::class,
    )->forPlatform(
        section: $section,
    );

    expect($result)->toHaveKey('values');
    expect($result)->toHaveKey('count');
    expect($result['values'])->toBeArray();
    expect($result['count'])->toBeInt();
});

test('unsupported section throws exception', function (): void {
    $section = new Section;
    $section->id = 9999;

    expect(fn () => app(SectionGroupResultCalculator::class)->forPlatform(section: $section))
        ->toThrow(RuntimeException::class, 'Unsupported graph section [9999].');
});

test('temperament class result is calculated correctly', function (): void {
    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: Section::findOrFail(8),
        class: SchoolClass::findOrFail(123),
    );

    expect($result)->toBe([
        'values' => [
            'Trait name 1' => 54,
            'Trait name 2' => 61,
        ],
        'count' => 23,
    ]);
});

test('tier percentages total approximately one hundred', function (): void {
    $result = app(
        SectionGroupResultCalculator::class,
    )->forPlatform(
        section: Section::findOrFail(9),
    );

    expect(array_sum($result['values']))->toEqualWithDelta(100, 1);
});

test('empty class returns empty graph result', function (): void {
    $class = SchoolClass::factory()->create();

    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: Section::findOrFail(8),
        class: $class,
    );

    expect($result)->toBe([
        'values' => [],
        'count' => 0,
    ]);
});
