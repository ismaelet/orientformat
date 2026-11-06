<?php

namespace Tests\Feature;

use App\Models\Activities\Test as ActivityTest;
use App\Models\Results\User\TestResult;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\ResultsFixture;
use Tests\TestCase;

// Pest's runner does not set the autoloader path needed by PHPUnit's isolated process.
if (! defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', dirname(__DIR__, 2).'/vendor/autoload.php');
}

class TemperamentRecapResetTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function temperament_recap_restart_targets_the_selected_test_reset_endpoint(): void
    {
        $fixture = ResultsFixture::seed();
        $studentId = $fixture['students'][0]->userId;
        $this->actingAs(User::findOrFail($studentId));
        DB::table('school_classes')->where('id', $fixture['class']->id)->update([
            'grade' => 1, 'startingGrade' => 1, 'professional' => 0,
        ]);
        DB::table('activities_areas')->updateOrInsert(['id' => 1], [
            'name' => 'Profile', 'slug' => 'profile', 'description' => '', 'color1' => '', 'color2' => '',
        ]);
        DB::table('sections')->where('id', 8)->update(['slug' => 'temperamento']);
        DB::table('activities_grades')->updateOrInsert(
            ['absolute_number' => 1, 'is_professional' => 0],
            ['school_relative_number' => 1, 'is_highschool' => 0],
        );
        $gradeId = DB::table('activities_grades')->where('absolute_number', 1)->where('is_professional', 0)->value('id');
        DB::table('grade_section')->updateOrInsert(['grade_id' => $gradeId, 'section_id' => 8]);

        foreach (['stabilita', 'estroversione', 'socievolezza', 'coscienziosita', 'novita'] as $index => $slug) {
            DB::table('tests')->where('id', 41 + $index)->update([
                'sectionId' => 8, 'areaId' => 1, 'slug' => $slug, 'step' => $index + 1,
                'template' => 'blade', 'active' => 1, 'recapTestId' => 46,
            ]);
        }
        DB::table('tests')->where('id', 46)->update([
            'sectionId' => 8, 'areaId' => 1, 'slug' => 'riepilogo', 'step' => 6,
            'template' => 'test', 'active' => 1, 'recapTestId' => 0,
        ]);
        TestResult::replaceCurrent([
            'studentId' => $studentId, 'testId' => 42, 'result' => '1,2,3,4',
            'percentage' => 50, 'completed' => true, 'speed' => 0,
        ]);
        DB::table('results_others')->insert(['userID' => $studentId, 'testID' => 42, 'result' => 'old']);
        $recap = ActivityTest::findOrFail(46);
        $target = ActivityTest::findOrFail(42);

        $this->get($recap->url())
            ->assertOk()
            ->assertSee('formaction="'.route('test.reset', 42).'"', false);

        $this->post(route('test.reset', 42))->assertRedirect($target->url());
        $this->assertDatabaseMissing('results_tests', ['studentId' => $studentId, 'testId' => 42]);
        $this->assertDatabaseMissing('results_others', ['userID' => $studentId, 'testID' => 42]);
        $this->assertDatabaseHas('results_tests_archive', ['studentId' => $studentId, 'testId' => 42]);
        $this->get($target->url())->assertOk()->assertViewIs('tests.temperamento.estroversione');
    }
}
