<?php

use App\Models\Activities\Test as ActivityTest;
use App\Models\Results\User\TestResult;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Legacy\Activity\Result\TestResult as LegacyTestResult;
use Legacy\Activity\Test;
use Tests\Support\ResultsFixture;

beforeEach(function (): void {
    $fixture = ResultsFixture::seed();
    $this->student = Student::where('userId', $fixture['students'][0]->userId)->firstOrFail();
    $this->otherStudent = Student::where('userId', $fixture['students'][1]->userId)->firstOrFail();
    $this->actingAs(User::findOrFail($this->student->userId));

    DB::table('school_classes')->where('id', $fixture['class']->id)->update(['grade' => 1, 'professional' => 0]);
    DB::table('activities_grades')->insert(['id' => 9000, 'absolute_number' => 1, 'is_professional' => 0]);
    DB::table('grade_section')->insert(['grade_id' => 9000, 'section_id' => 9]);
    DB::table('tests')->where('sectionId', 9)->update(['active' => 0]);
    DB::table('tests')->where('id', 16)->update(['active' => 1, 'step' => 1]);
    DB::table('tests')->where('id', 22)->update(['active' => 1, 'step' => 2, 'recapTestId' => 16]);

    $this->test = ActivityTest::findOrFail(16);
});

test('replacement and reset preserve history without restoring an older result as current', function (): void {
    $oldId = $this->student->testResult($this->test)->id;
    TestResult::replaceCurrent([
        'studentId' => $this->student->id,
        'testId' => $this->test->id,
        'result' => 'new',
        'percentage' => 50,
        'completed' => true,
        'speed' => 12,
    ]);

    $this->student->unsetRelation('test_results');
    $current = $this->student->testResult($this->test);
    expect($current->result)->toBe('new')
        ->and($this->test->completedAttemptsFor($this->student))->toBe(2);
    $this->assertDatabaseHas('results_tests_archive', ['id' => $oldId, 'percentage' => 80]);

    $this->post(route('test.reset', $this->test->id))->assertRedirect();

    $this->student->unsetRelation('test_results');
    expect($this->student->hasCompletedTest($this->test))->toBeFalse()
        ->and($this->student->testResult($this->test))->toBeNull()
        ->and($this->test->completedAttemptsFor($this->student))->toBe(2)
        ->and((new Test($this->test->id))->completed)->toBeFalse();
    $this->assertDatabaseHas('results_tests_archive', ['id' => $current->id, 'result' => 'new']);
    $this->assertDatabaseHas('results_tests', ['studentId' => $this->otherStudent->id, 'testId' => $this->test->id]);

    $this->post(route('test.reset', $this->test->id))->assertRedirect();
    expect($this->test->completedAttemptsFor($this->student))->toBe(2);

    TestResult::replaceCurrent([
        'studentId' => $this->student->id,
        'testId' => $this->test->id,
        'result' => 'retaken',
        'percentage' => 90,
        'completed' => true,
        'speed' => 3,
    ]);
    $this->student->unsetRelation('test_results');
    expect($this->student->testResult($this->test)->result)->toBe('retaken')
        ->and($this->test->completedAttemptsFor($this->student))->toBe(3);
});

test('dependent reset archives each current result and refreshes section progress', function (): void {
    DB::table('results_sections_condensed')->insert([
        'student_id' => $this->student->id, 'section_id' => 9, 'result' => 'old', 'speed' => 1,
    ]);

    $this->post(route('test.reset.dependent', $this->test->id))->assertRedirect();

    foreach ([16, 22] as $testId) {
        $this->assertDatabaseMissing('results_tests', ['studentId' => $this->student->id, 'testId' => $testId]);
        $this->assertDatabaseHas('results_tests_archive', ['studentId' => $this->student->id, 'testId' => $testId]);
    }

    $this->assertDatabaseHas('results_sections', [
        'studentId' => $this->student->id, 'sectionId' => 9,
        'completedTestCount' => 0, 'progressPercentage' => 0, 'completed' => 0,
    ]);
    $this->assertDatabaseMissing('results_sections_condensed', ['student_id' => $this->student->id, 'section_id' => 9]);
});

test('legacy saves and redo use the same current and historical results', function (): void {
    LegacyTestResult::new([
        'studentId' => $this->student->id, 'testId' => 16, 'results' => 'legacy',
        'percentage' => 40, 'completed' => true, 'speed' => 2,
    ]);
    expect($this->test->completedAttemptsFor($this->student))->toBe(2);

    (new Test(16))->redo();
    $this->assertDatabaseMissing('results_tests', ['studentId' => $this->student->id, 'testId' => 16]);
    $this->assertDatabaseHas('results_tests_archive', ['studentId' => $this->student->id, 'testId' => 16, 'result' => 'legacy']);
    expect($this->test->completedAttemptsFor($this->student))->toBe(2);
});

test('an incomplete current result does not expose a completed historical attempt', function (): void {
    TestResult::replaceCurrent([
        'studentId' => $this->student->id, 'testId' => 16, 'result' => 'in progress',
        'percentage' => 0, 'completed' => false, 'speed' => 0,
    ]);
    $this->student->unsetRelation('test_results');

    expect($this->student->hasCompletedTest($this->test))->toBeFalse()
        ->and($this->student->testResult($this->test)->result)->toBe('in progress')
        ->and($this->test->completedAttemptsFor($this->student))->toBe(1);
});

test('modern submissions replace the current result and preserve section progress', function (): void {
    $this->test->storeResult($this->student, ['fresh'], 7, Request::create('/'));
    $this->student->unsetRelation('test_results');

    expect($this->student->testResult($this->test)->result)->toBe('fresh')
        ->and($this->test->completedAttemptsFor($this->student))->toBe(2);
    $this->assertDatabaseHas('results_sections', [
        'studentId' => $this->student->id, 'sectionId' => 9, 'completedTestCount' => 2,
    ]);
});

test('the database rejects multiple current results for the same pair', function (): void {
    expect(fn () => TestResult::create([
        'studentId' => $this->student->id, 'testId' => 16, 'result' => 'duplicate',
        'percentage' => 1, 'completed' => true, 'speed' => 0,
    ]))->toThrow(QueryException::class);
});

test('history can retain attempts with reused original result ids', function (): void {
    $current = TestResult::where('studentId', $this->student->id)->where('testId', 16)->firstOrFail();
    DB::table('results_tests_archive')->insert($current->getRawOriginal());

    $this->post(route('test.reset', 16))->assertRedirect();

    expect(DB::table('results_tests_archive')->where('id', $current->id)->count())->toBe(2)
        ->and($this->test->completedAttemptsFor($this->student))->toBe(2);
});

test('teacher simulation can reset a current attempt without affecting students', function (): void {
    $teacher = User::factory()->create();
    $teacherId = $teacher->id;
    Teacher::create(['id' => $teacherId, 'user_id' => $teacherId]);
    $this->actingAs($teacher);
    TestResult::replaceCurrent([
        'studentId' => $teacherId, 'testId' => 16, 'result' => 'teacher',
        'percentage' => 100, 'completed' => true, 'speed' => 0,
    ]);

    $this->post(route('test.reset', 16))->assertRedirect();
    $this->assertDatabaseMissing('results_tests', ['studentId' => $teacherId, 'testId' => 16]);
    $this->assertDatabaseHas('results_tests_archive', ['studentId' => $teacherId, 'testId' => 16]);
    $this->assertDatabaseHas('results_tests', ['studentId' => $this->student->id, 'testId' => 16]);
});

test('migration retains the highest id per pair and restores history on rollback', function (): void {
    config(['database.connections.history_migration_test' => [
        'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true,
    ]]);
    $previous = DB::getDefaultConnection();
    DB::setDefaultConnection('history_migration_test');

    try {
        Schema::create('results_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('studentId');
            $table->integer('testId');
            $table->boolean('completed');
            $table->string('result');
            $table->integer('percentage');
            $table->integer('speed');
            $table->timestamp('time')->useCurrent();
            $table->timestamps();
        });
        foreach ([[1, 1, 16], [2, 1, 16], [3, 2, 16], [4, 1, 22]] as [$id, $studentId, $testId]) {
            DB::table('results_tests')->insert([
                'id' => $id, 'studentId' => $studentId, 'testId' => $testId,
                'completed' => 1, 'result' => (string) $id, 'percentage' => 50, 'speed' => 0,
            ]);
        }

        $migration = require database_path('migrations/2026_11_06_120000_separate_historical_test_results.php');
        $migration->up();
        expect(DB::table('results_tests')->orderBy('id')->pluck('id')->all())->toBe([2, 3, 4])
            ->and(DB::table('results_tests_archive')->pluck('id')->all())->toBe([1]);
        $migration->down();
        expect(DB::table('results_tests')->orderBy('result')->pluck('result')->all())->toBe(['1', '2', '3', '4'])
            ->and(Schema::hasTable('results_tests_archive'))->toBeFalse();
    } finally {
        DB::setDefaultConnection($previous);
        DB::purge('history_migration_test');
    }
});
