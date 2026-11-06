<?php

namespace Tests\Support;

use App\Models\Activities\Test;
use App\Models\User;
use App\Models\User\Student;
use Illuminate\Support\Facades\DB;

final class TemperamentoFixture
{
    public const EMAIL = 'temperamento-student@example.test';

    public const PASSWORD = 'password';

    public const SECTION_ID = 9200;

    public static function seed(): array
    {
        DB::table('config')->updateOrInsert(['name' => 'public'], ['value' => '1']);
        DB::table('activities_areas')->updateOrInsert(['id' => 1], [
            'name' => 'Profilo', 'slug' => 'profile', 'description' => 'Fixture', 'color1' => '', 'color2' => '',
        ]);
        DB::table('activities_grades')->updateOrInsert(['id' => 1], [
            'absolute_number' => 1, 'school_relative_number' => 1, 'is_highschool' => 0, 'is_professional' => 0,
        ]);
        DB::table('schools')->updateOrInsert(['id' => self::SECTION_ID], ['name' => 'Scuola temperamento']);
        DB::table('school_classes')->updateOrInsert(['id' => self::SECTION_ID], [
            'schoolId' => self::SECTION_ID, 'name' => '1A', 'letter' => 'A', 'code' => 'TEMPE2E',
            'grade' => 1, 'startingGrade' => 1, 'startingYear' => now()->year, 'year' => now()->year,
            'professional' => 0, 'ended' => 0, 'deleted_at' => null,
        ]);
        DB::table('sections')->updateOrInsert(['id' => self::SECTION_ID], [
            'areaId' => 1, 'name' => 'Temperamento', 'slug' => 'temperamento',
            'description' => 'Fixture', 'isStandard' => 1, 'active' => 1, 'deleted_at' => null,
        ]);
        DB::table('grade_section')->updateOrInsert(['grade_id' => 1, 'section_id' => self::SECTION_ID]);

        $user = User::firstOrCreate(['email' => self::EMAIL], [
            'first_name' => 'Temperamento', 'last_name' => 'Student', 'password' => bcrypt(self::PASSWORD),
        ]);
        Student::updateOrCreate(['id' => $user->id], ['userId' => $user->id, 'schoolClassId' => self::SECTION_ID]);

        $urls = [];
        foreach (['stabilità', 'estroversione', 'socievolezza', 'coscienziosità', 'novità'] as $index => $slug) {
            $id = 41 + $index;
            DB::table('tests')->updateOrInsert(['id' => $id], [
                'sectionId' => self::SECTION_ID, 'areaId' => 1, 'title' => $slug,
                'slug' => $slug, 'step' => $index + 1, 'template' => 'blade', 'active' => 1,
                'description' => 'Fixture', 'shortDescription' => 'Fixture',
                'reviewResult' => 0, 'deleted_at' => null,
            ]);
            $urls[] = parse_url(Test::findOrFail($id)->url(), PHP_URL_PATH);
        }

        DB::table('results_tests')->where('studentId', $user->id)->whereIn('testId', range(41, 45))->delete();
        DB::table('results_sections')->where('studentId', $user->id)->where('sectionId', self::SECTION_ID)->delete();
        DB::table('results_grades')->where('studentId', $user->id)->delete();

        return ['urls' => $urls, 'sectionUrl' => '/activities/sections/'.self::SECTION_ID];
    }

    public static function results(): array
    {
        return DB::table('results_tests')
            ->where('studentId', User::where('email', self::EMAIL)->value('id'))
            ->whereIn('testId', range(41, 45))
            ->orderBy('testId')
            ->get(['testId', 'result', 'percentage', 'completed'])
            ->toArray();
    }
}
