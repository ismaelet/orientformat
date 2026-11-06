<?php

use App\Helpers\Tests\TemperamentoHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class);

dataset('temperamento activities', [
    [41, 'stabilità'],
    [42, 'estroversione'],
    [43, 'socievolezza'],
    [44, 'coscienziosità'],
    [45, 'novità'],
]);

function temperamentTest(int $id = 41, string $slug = 'stabilità'): Test
{
    $test = new Test;
    $test->id = $id;
    $test->slug = $slug;
    $test->setRelation('section', new Section(['slug' => 'temperamento', 'isStandard' => true]));
    // isStandard is not mass assignable.
    $test->section->isStandard = true;

    return $test;
}

test('temperament activities resolve their Blade view and translated questions', function (int $id, string $slug): void {
    $test = temperamentTest($id, $slug);
    $helper = $test->helper();

    expect($helper)->toBeInstanceOf(TemperamentoHelper::class)
        ->and($test->view())->toBe('tests.temperamento.'.$slug)
        ->and(view()->exists($test->view()))->toBeTrue();

    $questions = $helper->viewData($test)['questions'];
    expect($questions)->toHaveCount(4);

    foreach ($questions as $index => $question) {
        expect($question)->toBe([
            __('tests.'.$id.'-answer-'.($index + 1).'-negative'),
            __('tests.'.$id.'-answer-'.($index + 1).'-positive'),
        ]);
    }
})->with('temperamento activities');

test('temperament scoring preserves the legacy scale and rounding', function (array $answers, int $score): void {
    expect(temperamentTest()->helper()->calculatePercentage($answers))->toBe($score);
})->with([
    [[0, 0, 0, 0], 0],
    [[5, 5, 5, 5], 100],
    [['0', '2', '3', '5'], 50],
    [[0, 0, 0, 1], 5],
]);

test('temperament submissions use modern result storage and navigation', function (): void {
    $test = Mockery::mock(Test::class);
    $student = Mockery::mock(Student::class);
    $request = Request::create('/', 'POST', ['field' => ['0', '2', '3', '5'], 'speed' => 17]);
    $student->shouldReceive('hasCompletedTest')->with($test)->once()->andReturnFalse();
    $test->shouldReceive('storeResult')->with($student, ['0', '2', '3', '5'], 17, $request)->once();
    $test->shouldReceive('nextUrl')->with($student)->once()->andReturn('/next');

    expect(temperamentTest()->helper()->store($request, $test, $student)->getTargetUrl())->toBe(url('/next'));
});

test('completed temperament activities advance without another result', function (): void {
    $test = Mockery::mock(Test::class);
    $student = Mockery::mock(Student::class);
    $student->shouldReceive('hasCompletedTest')->with($test)->once()->andReturnTrue();
    $test->shouldNotReceive('storeResult');
    $test->shouldReceive('nextUrl')->with($student)->once()->andReturn('/next');

    expect(temperamentTest()->helper()->store(Request::create('/', 'POST'), $test, $student)->getTargetUrl())
        ->toBe(url('/next'));
});

test('invalid temperament answers are rejected before saving', function (mixed $answers): void {
    $test = Mockery::mock(Test::class);
    $student = Mockery::mock(Student::class);
    $student->shouldReceive('hasCompletedTest')->andReturnFalse();
    $test->shouldNotReceive('storeResult');

    temperamentTest()->helper()->store(Request::create('/', 'POST', ['field' => $answers]), $test, $student);
})->with([
    'missing' => [null],
    'too few' => [[0, 1, 2]],
    'too many' => [[0, 1, 2, 3, 4]],
    'negative' => [[-1, 1, 2, 3]],
    'too high' => [[6, 1, 2, 3]],
    'fraction' => [[1.5, 1, 2, 3]],
    'empty' => [['', 1, 2, 3]],
    'nested' => [[[1], 1, 2, 3]],
    'unordered keys' => [[1 => 0, 2 => 1, 3 => 2, 4 => 3]],
])->throws(ValidationException::class);

test('temperament validation recovery preserves zero and clears malformed answers', function (): void {
    request()->setLaravelSession(app('session.store'));
    session()->flashInput(['field' => ['0', '5', ['bad'], '7']]);

    expect(temperamentTest()->helper()->viewData(temperamentTest())['answers'])->toBe(['0', '5', null, null]);
});
