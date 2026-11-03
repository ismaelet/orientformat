<?php

use App\Models\ReviewResult;
use App\Models\User;
use Tests\Support\ReviewFixture;

/*
 * Backend behaviour of the review questionnaire. DatabaseTransactions (Pest.php)
 * rolls back the fixture after every test; TestDatabaseGuard blocks any
 * database other than orientformat_test.
 */

beforeEach(function (): void {
    $this->student = ReviewFixture::seed();
    $this->actingAs(User::find($this->student->userId));
    $this->url = route('review.store', ReviewFixture::REVIEW_ID);

    $this->validAnswers = [
        'review_id' => ReviewFixture::REVIEW_ID,
        's2d2_1' => '1', 's2d2_2' => '1', 's2d2_3' => '1', 's2d2_4' => '1',
        's6d1' => '12',
        's6d2' => '1',
        's7d2' => '3',
    ];

    $this->saved = fn (): ?ReviewResult => ReviewResult::where('studentId', $this->student->userId)
        ->where('reviewId', ReviewFixture::REVIEW_ID)
        ->first();
});

test('the questionnaire page renders every fixture question', function (): void {
    $response = $this->get(route('review.show', ReviewFixture::REVIEW_ID))->assertOk();

    $response->assertSee('data-review-form', false);
    $response->assertSee('js-attempt-submit', false);

    foreach (['s2d2', 's2d3a', 's2d3b', 's2d3c', 's2d3d', 's6d1', 's6d2', 's6d3', 's7d2', 's7d3', 's7d4', 's7d5'] as $id) {
        $response->assertSee('id="question-'.$id.'"', false);
    }
});

test('the questionnaire page shows the completion message once results exist', function (): void {
    ReviewResult::create([
        'studentId' => $this->student->userId,
        'reviewId' => ReviewFixture::REVIEW_ID,
        'results' => 's6d1=1',
    ]);

    $this->get(route('review.show', ReviewFixture::REVIEW_ID))
        ->assertOk()
        ->assertSee('completato il formulario', false)
        ->assertDontSee('js-attempt-submit', false);
});

test('guests are redirected to the login page', function (): void {
    auth()->logout();

    $this->post($this->url, $this->validAnswers)->assertRedirectToRoute('login');
    $this->get(route('review.show', ReviewFixture::REVIEW_ID))->assertRedirectToRoute('login');
});

test('a complete submission is saved and redirects back with the success flag', function (): void {
    $this->from(route('review.show', ReviewFixture::REVIEW_ID))
        ->post($this->url, $this->validAnswers)
        ->assertRedirect(route('review.show', ReviewFixture::REVIEW_ID))
        ->assertSessionHas('success', true);

    $results = ($this->saved)()->results();

    expect($results)->toMatchArray([
        's2d2_1' => '1', 's2d2_2' => '1', 's2d2_3' => '1', 's2d2_4' => '1',
        's6d1' => '12',
        's6d2' => '1',
        's7d2' => '3',
    ]);
});

test('the csrf token is never stored', function (): void {
    $this->post($this->url, $this->validAnswers + ['_token' => 'abc']);

    expect(($this->saved)()->results)->not->toContain('_token');
});

test('only validated answers are stored, in the legacy key=value format', function (): void {
    $this->post($this->url, $this->validAnswers + ['unknown' => 'x', 's7d4' => '1']);

    expect(($this->saved)()->results)
        ->toBe('s2d2_1=1,s2d2_2=1,s2d2_3=1,s2d2_4=1,s6d1=12,s6d2=1,s7d2=3');
});

test('a completed questionnaire cannot be submitted again', function (): void {
    $this->post($this->url, $this->validAnswers)->assertSessionHas('success', true);

    $this->post($this->url, ['s6d1' => '50'] + $this->validAnswers)
        ->assertSessionHasErrors('review_id');

    expect(ReviewResult::where('reviewId', ReviewFixture::REVIEW_ID)->count())->toBe(1)
        ->and(($this->saved)()->results()['s6d1'])->toBe('12');
});

test('conditionally required answers are saved when their parent triggers them', function (): void {
    $this->post($this->url, ['s6d2' => '2', 's6d3' => '1', 's2d2_2' => '3', 's2d3b_1' => '1'] + $this->validAnswers)
        ->assertSessionHasNoErrors();

    expect(($this->saved)()->results())->toMatchArray(['s6d3' => '1', 's2d3b_1' => '1']);
});

test('optional and conditionally hidden answers may be omitted', function (): void {
    $this->post($this->url, $this->validAnswers)->assertSessionHas('success', true);

    $results = ($this->saved)()->results();

    foreach (['s6d3', 's7d3', 's7d4', 's7d5', 's2d3a_1'] as $hidden) {
        expect($results)->not->toHaveKey($hidden);
    }
});

test('the backend rejects missing required answers', function (string $field): void {
    $answers = $this->validAnswers;
    unset($answers[$field]);

    $this->post($this->url, $answers)->assertSessionHasErrors($field);

    expect(($this->saved)())->toBeNull();
})->with(['s2d2_1', 's2d2_4', 's6d1', 's6d2', 's7d2']);

test('the backend rejects an entirely empty submission', function (): void {
    $this->post($this->url, ['review_id' => ReviewFixture::REVIEW_ID])
        ->assertSessionHasErrors(['s2d2_1', 's2d2_2', 's2d2_3', 's2d2_4', 's6d1', 's6d2', 's7d2']);

    expect(($this->saved)())->toBeNull();
});

test('the backend rejects invalid numbers', function (mixed $value): void {
    $this->post($this->url, ['s6d1' => $value] + $this->validAnswers)->assertSessionHasErrors('s6d1');

    expect(($this->saved)())->toBeNull();
})->with([['0'], ['101'], ['-5'], ['1.5'], ['abc'], ['1e1'], ["1'2=3"], [''], [[['1']]], [[['a' => '1']]]]);

test('the backend accepts the numeric boundaries', function (string $value): void {
    $this->post($this->url, ['s6d1' => $value] + $this->validAnswers)->assertSessionHasNoErrors();

    expect(($this->saved)()->results()['s6d1'])->toBe($value);
})->with(['1', '100']);

test('the backend rejects option values that do not exist', function (string $field, mixed $value): void {
    $this->post($this->url, [$field => $value] + $this->validAnswers)->assertSessionHasErrors($field);

    expect(($this->saved)())->toBeNull();
})->with([
    'list too high' => ['s6d2', '4'],
    'list zero' => ['s6d2', '0'],
    'list text' => ['s7d2', 'one'],
    'list array' => ['s7d2', ['1', '2']],
    'grid too high' => ['s2d2_1', '5'],
    'grid negative' => ['s2d2_2', '-1'],
]);

test('the backend requires dependent answers when the parent answer triggers them', function (array $parent, array $missing): void {
    $this->post($this->url, $parent + $this->validAnswers)->assertSessionHasErrors($missing);

    expect(($this->saved)())->toBeNull();
})->with([
    's6d2 above 1' => [['s6d2' => '2'], ['s6d3']],
    's7d2 equals 1' => [['s7d2' => '1'], ['s7d3']],
    's7d2 equals 2' => [['s7d2' => '2'], ['s7d4', 's7d5']],
    's2d2 row above 1' => [['s2d2_3' => '2'], ['s2d3c_1']],
]);

test('a triggered multiple question needs at least one option, and accepts any', function (): void {
    $answers = ['s2d2_1' => '2'] + $this->validAnswers;

    $this->post($this->url, $answers)->assertSessionHasErrors('s2d3a_1');
    $this->post($this->url, ['s2d3a_3' => '1'] + $answers)->assertSessionHasNoErrors();

    expect(($this->saved)()->results())->toMatchArray(['s2d3a_3' => '1']);
});

test('answers to hidden dependent questions are discarded, not trusted', function (): void {
    $this->post($this->url, $this->validAnswers + ['s6d3' => '1', 's7d3' => '1', 's7d4' => '9', 's2d3a_1' => '1'])
        ->assertSessionHasNoErrors();

    $results = ($this->saved)()->results();

    expect($results)->not->toHaveKeys(['s6d3', 's7d3', 's7d4', 's2d3a_1']);
});

test('client supplied visibility, optional and completion flags are ignored', function (): void {
    $forged = [
        'optional' => '1', 'data-optional' => '1', 'completed' => '1', 'dataset' => ['optional' => '1'],
        'question--completed' => '1', 's6d3_optional' => '1', 'visible' => '0',
    ];

    $this->post($this->url, $forged + ['s6d2' => '2'] + $this->validAnswers)->assertSessionHasErrors('s6d3');

    expect(($this->saved)())->toBeNull();
});

test('malformed and malicious payloads are rejected or ignored without side effects', function (array $extra): void {
    $this->post($this->url, $extra + $this->validAnswers);

    $results = ($this->saved)()?->results ?? '';

    expect($results)->not->toContain('<script')->not->toContain('DROP')->not->toContain('99');
})->with([
    'sql in value' => [['s6d2' => "1'; DROP TABLE review_results;--"]],
    'xss in value' => [['s6d1' => '<script>alert(1)</script>']],
    'unknown field' => [['s9d9' => '99', '__proto__' => '99']],
    'nested array field' => [['s6d2' => ['x' => ['99']]]],
    'comma injection' => [['s7d2' => '3,s6d1=99']],
]);

test('the review must exist and be identified', function (mixed $reviewId): void {
    $answers = $this->validAnswers;

    $this->post($this->url, ['review_id' => $reviewId] + $answers)->assertSessionHasErrors('review_id');

    expect(ReviewResult::where('studentId', $this->student->userId)->count())->toBe(0);
})->with(['missing review' => [999999], 'text' => ['abc'], 'array' => [['1']], 'empty' => ['']]);

test('users without a student profile cannot submit', function (): void {
    $this->actingAs(User::factory()->create());

    $this->post($this->url, $this->validAnswers)->assertRedirectToRoute('home');

    expect(ReviewResult::where('reviewId', ReviewFixture::REVIEW_ID)->count())->toBe(0);
});
