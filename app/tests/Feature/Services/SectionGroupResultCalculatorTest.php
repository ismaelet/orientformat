<?php

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Teacher;
use App\Services\Results\SectionGroupResultCalculator;
use Tests\Support\ResultsFixture;

beforeEach(function (): void {
    $this->fixture = ResultsFixture::seed();
});

test('class named percentage result has expected shape', function (): void {
    $section = Section::findOrFail(8);
    $class = $this->fixture['class'];

    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: $section,
        schoolClass: $class,
    );

    expect($result)->toHaveKey('values');
    expect($result)->toHaveKey('count');
    expect($result['values'])->toBeArray();
    expect($result['count'])->toBeInt();
});

test('class tier result has expected shape', function (): void {
    $section = Section::findOrFail(9);
    $class = $this->fixture['class'];

    $result = app(
        SectionGroupResultCalculator::class,
    )->forSchoolClass(
        section: $section,
        schoolClass: $class,
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
    $result = app(SectionGroupResultCalculator::class)->forSchoolClass(
        Section::findOrFail(8),
        $this->fixture['class'],
    );

    expect($result)
        ->toHaveKeys(['values', 'count'])
        ->and($result['values'])->toBeArray()
        ->and($result['count'])->toBeInt()->toBeGreaterThanOrEqual(0);

    foreach ($result['values'] as $trait => $value) {
        expect($trait)->toBeString();
        expect($value)->toBeNumeric();
    }
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
    $user = User::factory()->create();

    $teacher = Teacher::create([
        'id' => $user->id,
        'user_id' => $user->id,
    ]);

    $class = SchoolClass::factory()->create([
        'referentId' => $teacher->id,
    ]);

    $result = app(SectionGroupResultCalculator::class)->forSchoolClass(
        Section::findOrFail(8),
        $class,
    );

    expect($result)->toBe([
        'values' => [],
        'count' => 0,
    ]);
});
