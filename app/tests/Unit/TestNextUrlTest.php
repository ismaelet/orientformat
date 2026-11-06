<?php

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Tests\TestCase;

uses(TestCase::class);

test('recap navigation requires the next or recap test to be completed', function (bool $nextCompleted, bool $recapCompleted, string $expected, string $userClass): void {
    $test = Mockery::mock(Test::class)->makePartial();
    $test->recapTestId = 30;
    $next = Mockery::mock(Test::class)->makePartial();
    $next->shouldReceive('url')->andReturn('/next');
    $recap = Mockery::mock(Test::class)->makePartial();
    $recap->shouldReceive('url')->andReturn('/recap');
    $section = new Section;
    $test->setRelation('section', $section);
    $test->setRelation('recap_test', $recap);
    $test->shouldReceive('nextTest')->once()->andReturn($next);
    $student = Mockery::mock($userClass === 'student' ? Student::class : Teacher::class);
    $student->shouldReceive('hasCompletedTest')->with($next)->andReturn($nextCompleted);
    $student->shouldReceive('hasCompletedTest')->with($recap)->andReturn($recapCompleted);
    $student->shouldReceive('hasCompletedSection')->with($section)->andReturnFalse();

    expect($test->nextUrl($student))->toBe($expected);
})->with([
    [false, false, '/next'],
    [true, false, '/recap'],
    [false, true, '/recap'],
    [true, true, '/recap'],
])->with(['student', 'teacher']);

test('completed recap navigation works without a next test', function (bool $completed): void {
    $test = Mockery::mock(Test::class)->makePartial();
    $test->recapTestId = 30;
    $recap = Mockery::mock(Test::class)->makePartial();
    $recap->shouldReceive('url')->andReturn('/recap');
    $section = Mockery::mock(Section::class)->makePartial();
    $section->shouldReceive('url')->andReturn('/section');
    $test->setRelation('section', $section);
    $test->setRelation('recap_test', $recap);
    $test->shouldReceive('nextTest')->once()->andReturnNull();
    $student = Mockery::mock(Student::class);
    $student->shouldReceive('hasCompletedTest')->with($recap)->once()->andReturn($completed);
    $student->shouldReceive('hasCompletedSection')->andReturnFalse();

    expect($test->nextUrl($student))->toBe($completed ? '/recap' : '/section');
})->with([false, true]);

test('review takes priority over recap navigation', function (): void {
    $test = Mockery::mock(Test::class)->makePartial();
    $test->reviewResult = true;
    $test->recapTestId = 30;
    $test->shouldReceive('url')->once()->andReturn('/review');
    $test->shouldNotReceive('nextTest');

    expect($test->nextUrl(Mockery::mock(Student::class)))->toBe('/review');
});
