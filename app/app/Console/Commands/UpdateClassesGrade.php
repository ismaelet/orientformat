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
            ->with('grade_level')
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

            $oldGradeLevel = $class->grade_level;
            $newGradeLevel = Grade::getByNumber($realNewGrade, $class->isProfessional());

            $newName = str_replace($oldGradeLevel->school_relative_number, $newGradeLevel->school_relative_number, $class->letter);

            $class->update([
                'grade' => $realNewGrade,
                'name' => $newName,
                'letter' => $newName,
                'year' => $currentClassYear,
                'ended' => $ended,
                'grade_level_id' => $newGradeLevel->id,
            ]);
        }

        return 0;
    }
}
