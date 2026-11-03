<?php

namespace Tests\Support;

use App\Models\User;
use App\Models\User\Student;
use Illuminate\Support\Facades\DB;

/**
 * Deterministic review questionnaire used by the Pest and Playwright suites.
 * Ids live in a dedicated range and only the test database is ever touched.
 */
final class ReviewFixture
{
    public const REVIEW_ID = 9001;

    public const EMAIL = 'review-student@example.test';

    public const PASSWORD = 'password';

    /** Visible, always-required questions (besides the grid rows of s2d2). */
    public const REQUIRED = ['s2d2', 's6d1', 's6d2', 's7d2'];

    public static function seed(): Student
    {
        $areas = [2 => 'Area 2', 6 => 'Area 6', 7 => 'Area 7'];

        foreach ($areas as $id => $title) {
            DB::table('review_areas')->updateOrInsert(['id' => $id], ['title' => $title, 'text' => '']);
        }

        DB::table('reviews')->updateOrInsert(['id' => self::REVIEW_ID], [
            'title' => 'Review di test',
            'slug' => 'review-di-test',
            'description' => 'Fixture',
            'areas' => '2,6,7',
        ]);

        $id = 90000;
        foreach (self::questions() as $question) {
            DB::table('review_questions')->updateOrInsert(['id' => ++$id], $question + [
                'reviewIds' => '',
                'text' => 'Domanda '.$question['areaId'].'.'.$question['slug'],
                'gridHeader' => '',
                'rows' => '',
                'multiple' => 0,
                'grouppedBy' => 'rows',
                'optional' => 0,
            ]);
        }

        $user = User::firstOrCreate(['email' => self::EMAIL], [
            'first_name' => 'Review',
            'last_name' => 'Student',
            'password' => bcrypt(self::PASSWORD),
        ]);

        $student = Student::withTrashed()->firstOrCreate(['userId' => $user->id], ['id' => $user->id]);

        self::reset();

        return $student;
    }

    /** Removes saved answers so the questionnaire can be submitted again. */
    public static function reset(): void
    {
        DB::table('review_results')->where('reviewId', self::REVIEW_ID)->delete();
    }

    /** @return list<array<string, mixed>> */
    private static function questions(): array
    {
        $options = 'Prima opzione,Seconda opzione,Terza opzione';
        $multi = ['type' => 'list', 'multiple' => 1, 'optional' => 1, 'rows' => $options];
        $dependent = ['type' => 'list', 'optional' => 1, 'rows' => 'Si,No'];

        return [
            ['areaId' => 2, 'slug' => '2', 'type' => 'grid', 'gridHeader' => '1,2,3,4', 'rows' => 'Liceo,Tecnico,Professionale,Altro'],
            ['areaId' => 2, 'slug' => '3a'] + $multi,
            ['areaId' => 2, 'slug' => '3b'] + $multi,
            ['areaId' => 2, 'slug' => '3c'] + $multi,
            ['areaId' => 2, 'slug' => '3d'] + $multi,
            ['areaId' => 6, 'slug' => '1', 'type' => 'number'],
            ['areaId' => 6, 'slug' => '2', 'type' => 'list', 'rows' => $options],
            ['areaId' => 6, 'slug' => '3'] + $dependent,
            ['areaId' => 7, 'slug' => '2', 'type' => 'list', 'rows' => 'Prima,Seconda,Terza'],
            ['areaId' => 7, 'slug' => '3'] + $dependent,
            ['areaId' => 7, 'slug' => '4'] + $dependent,
            ['areaId' => 7, 'slug' => '5'] + $dependent,
        ];
    }
}
