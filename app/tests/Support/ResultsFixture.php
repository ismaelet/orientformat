<?php

namespace Tests\Support;

use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\DB;

/**
 * A class with two students who completed every baseline section, with
 * deterministic temperament (section 8) and attention (section 9) answers.
 */
final class ResultsFixture
{
    public const CLASS_ID = 9100;

    /** @return array{class: SchoolClass, students: list<Student>} */
    public static function seed(): array
    {
        BaselineFixture::seed();

        DB::table('schools')->updateOrInsert(['id' => self::CLASS_ID], ['name' => 'Scuola di test']);

        $user = User::factory()->create();
        $teacher = Teacher::create(['id' => $user->id, 'user_id' => $user->id]);

        $class = SchoolClass::factory()->create([
            'id' => self::CLASS_ID,
            'schoolId' => self::CLASS_ID,
            'referentId' => $teacher->id,
        ]);

        $students = [];

        foreach ([[80, '3,2,1,0', 70], [40, '1,1,1,1', 30]] as [$selfEvaluation, $raw, $temperament]) {
            $studentUser = User::factory()->create();
            $student = Student::create([
                'id' => $studentUser->id,
                'userId' => $studentUser->id,
                'schoolClassId' => $class->id,
            ]);

            foreach (BaselineFixture::SECTION_IDS as $sectionId) {
                DB::table('results_sections')->insert([
                    'studentId' => $studentUser->id, 'sectionId' => $sectionId, 'completed' => 1,
                ]);
            }

            self::answer($studentUser->id, 16, '', $selfEvaluation);
            self::answer($studentUser->id, 22, $raw, 0);

            foreach (BaselineFixture::TEMPERAMENT_TEST_IDS as $testId) {
                self::answer($studentUser->id, $testId, '', $temperament);
            }

            $students[] = $student;
        }

        return ['class' => $class, 'students' => $students];
    }

    private static function answer(int $studentId, int $testId, string $result, int $percentage): void
    {
        DB::table('results_tests')->insert([
            'studentId' => $studentId,
            'testId' => $testId,
            'completed' => 1,
            'result' => $result,
            'percentage' => $percentage,
            'created_at' => now(),
        ]);
    }
}
