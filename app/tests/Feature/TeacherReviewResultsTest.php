<?php

use App\Models\ReviewResult;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\DB;
use Tests\Support\ReviewFixture;

beforeEach(function (): void {
    $user = User::factory()->create();
    Teacher::factory()->forUser($user)->create();
    $teacher = Teacher::findOrFail($user->id);
    $this->class = SchoolClass::factory()->withReferent($teacher)->create();
    $teacher->classes()->attach($this->class);
    $this->student = ReviewFixture::seed();
    $this->student->update(['schoolClassId' => $this->class->id]);
    $this->result = ReviewResult::create([
        'studentId' => $this->student->userId,
        'reviewId' => ReviewFixture::REVIEW_ID,
        'results' => 's6d1=7,s6d2=2,s2d2_1=3,s7d2=1',
    ]);
    DB::table('review_questions')->where('id', '>', 90000)->update(['show_to_teacher' => '0']);
    DB::table('review_questions')->where('id', '>', 90000)->update(['full_slug' => DB::raw("CONCAT('s', areaId, 'd', slug)")]);
    DB::table('review_questions')->where('id', '>', 90000)->where('areaId', 6)->update([
        'show_to_teacher' => '1', 'teacher_text' => 'Teacher question',
    ]);
    $this->actingAs($user);
    $this->url = route('class.students.results.review', ['class' => $this->class, 'id' => $this->result->id]);
});

test('teachers can open the restored review result URL', function (): void {
    $this->get($this->url)->assertOk()
        ->assertViewIs('class.students.results.review')
        ->assertSee('Review di test')->assertSee('Teacher question');
});

test('review answers respect teacher visibility and decode saved choices', function (): void {
    $answers = $this->result->teacherAnswers();
    expect(array_column($answers, 'slug'))->toBe(['s6d1', 's6d2'])
        ->and($answers[0]['answers'][0]['value'])->toBe('7')
        ->and($answers[1]['answers'][0]['value'])->toBe('Seconda opzione');
});

test('review results from another class are not disclosed', function (): void {
    $this->student->update(['schoolClassId' => null]);
    $this->get($this->url)->assertNotFound();
});

test('missing and invalid review result IDs return not found', function (string $query): void {
    $this->get('/class/'.$this->class->id.'/students/results/review'.$query)->assertNotFound();
})->with(['', '?id=999999999', '?id[]=1', '?id=invalid']);

test('teachers cannot read review results in an unassigned class', function (): void {
    $other = User::factory()->create();
    Teacher::factory()->forUser($other)->create();
    $this->actingAs($other)->get($this->url)->assertRedirect(route('teacher.dashboard'));
});

test('grid and multiple answers retain their labels and numeric answers retain one', function (): void {
    DB::table('review_questions')->where('id', 90001)->update([
        'show_to_teacher' => '1', 'teacher_text' => 'Grid question',
    ]);
    DB::table('review_questions')->where('id', 90002)->update([
        'show_to_teacher' => '1', 'teacher_text' => 'Multiple question',
    ]);
    $this->result->results = 's6d1=1,s2d2_1=3,s2d3a_2=1';
    $answers = $this->result->teacherAnswers();
    expect($answers[0]['answers'])->toBe([['label' => '', 'value' => '1']])
        ->and($answers[1]['answers'])->toBe([['label' => 'Liceo', 'value' => '3']])
        ->and($answers[2]['answers'])->toBe([['label' => 'Seconda opzione', 'value' => '1']]);

    DB::table('review_questions')->where('id', 90001)->update(['reviewIds' => '2']);
    expect(array_column($this->result->teacherAnswers(), 'slug'))->not->toContain('s2d2');
});
