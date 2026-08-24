<?php

namespace App\Console\Commands;

use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Console\Command;

class UpdateClassesGrade extends Command {
    protected $signature = 'classes:update-grade';

    protected $description = 'Update the grade of school classes';

    public function handle(): int {
        $activeClasses = SchoolClass::where('ended', false)
            ->get();

        $currentYear = now()->year;

        $currentSchoolYear = now()->month >= 9 ? $currentYear : $currentYear - 1;

        foreach ($activeClasses as $class) {
            $startingYear = $class->startingYear;
            $startingGrade = $class->startingGrade;
            $lastGrade = $class->last_grade;

            $yearsPassed = $currentSchoolYear - $startingYear;
            $newGrade = $startingGrade + $yearsPassed;
            $ended = $newGrade > $lastGrade;
            $realNewGrade = $ended ? $lastGrade : $newGrade;

            $currentClassYear = $startingYear + $realNewGrade - $startingGrade;
            $newName = str_replace($class->grade, $realNewGrade, $class->letter);

            $gradeLevel = Grade::getByNumber($realNewGrade, $class->isProfessional());

            $class->update([
                'grade' => $realNewGrade,
                'letter' => $newName,
                'year' => $currentClassYear,
                'ended' => $ended,
                'grade_level_id' => $gradeLevel->id,
            ]);
        }

        return 0;
    }
}
