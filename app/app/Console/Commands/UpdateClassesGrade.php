<?php

namespace App\Console\Commands;

use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Console\Command;

class UpdateClassesGrade extends Command
{
    protected $signature = 'classes:update-grade';

    protected $description = 'Update the grade of school classes';

    public function handle(): int
    {
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

            $oldRelativeNumber = $oldGradeLevel->school_relative_number;
            $newRelativeNumber = $newGradeLevel->school_relative_number;

            // Make sure the new relative grade is numeric
            if (filter_var($newRelativeNumber, FILTER_VALIDATE_INT) === false) {
                $this->warn(
                    "Skipping class {$class->id} ({$class->name}): ".
                        "invalid school_relative_number '{$newRelativeNumber}' for grade level {$newGradeLevel->id}."
                );

                continue;
            }

            // Make sure the old relative grade actually exists in the class letter
            if (! str_contains($class->name, (string) $oldRelativeNumber)) {
                if (preg_match('/\d/', $class->name)) {
                    $this->warn(
                        "Skipping class {$class->id} ({$class->name}): ".
                            "old school_relative_number '{$oldRelativeNumber}' was not found."
                    );

                    continue;
                }

                $newName = $newRelativeNumber.$class->name;
            } else {
                $newName = str_replace(
                    (string) $oldRelativeNumber,
                    (string) $newRelativeNumber,
                    $class->name
                );
            }

            $class->update([
                'grade' => $realNewGrade,
                'name' => $newName,
                'letter' => $newName,
                'year' => $currentClassYear,
                'ended' => $ended,
                'grade_level_id' => $newGradeLevel->id,
            ]);
        }

        return Command::SUCCESS;
    }
}
