<?php

namespace App\Http\Controllers\SchoolClass;

use App\Helpers\ClassHelper;
use App\Http\Controllers\Controller;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the student list
     */
    public function studentIndex(SchoolClass $class)
    {
        $students = $class->students->load('user')->sortBy('inverted_full_name');

        return view('class.settings.students.index', [
            'class' => $class,
            'students' => $students,
        ]);
    }

    /**
     * Show the class settings
     */
    public function showSettings(SchoolClass $class)
    {
        $isHighschool = $class->isHighschool();
        $isProfessional = $class->isProfessional();

        $gradeModels = Grade::where('is_highschool', $isHighschool)
            ->where('is_professional', $isProfessional)
            ->orderBy('absolute_number')
            ->get();

        $grades = $gradeModels
            ->pluck('name', 'id')
            ->toArray();

        $gradeIdsByRelativeNumber = $gradeModels
            ->pluck('id', 'school_relative_number')
            ->toArray();

        return view('class.settings.index', [
            'class' => $class,
            'grades' => $grades,
            'gradeIdsByRelativeNumber' => $gradeIdsByRelativeNumber,
        ]);
    }

    /**
     * Update the class settings
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'grade' => 'required|exists:activities_grades,absolute_number',
            'letter' => 'required|string|max:10',
            'professional' => 'nullable|boolean',
        ]);

        $letter = strtoupper($request->input('letter'));
        $gradeNumber = $request->input('grade');
        $professional = $request->input('professional', false);
        $newGrade = Grade::getByNumber($gradeNumber, $professional);

        $startingYear = $class->startingYear;
        $currentYear = now()->year;
        $currentSchoolYear = $currentYear >= 9 ? $currentYear : $currentYear - 1;
        $yearDifference = $currentSchoolYear - $startingYear;
        $newStartingGrade = $newGrade->absolute_number - $yearDifference;

        $name = $class->isMiddleSchool() ? ClassHelper::generateName($gradeNumber, $letter) : $letter;

        $class->update([
            'grade_level_id' => $newGrade->id,
            'grade' => $newGrade->absolute_number,
            'startingGrade' => $newStartingGrade,
            'letter' => $name,
            'name' => $name,
            'professional' => ! $class->isMiddleSchool() && $request->input('professional'),
        ]);

        return redirect()->back()->with('success', 'Impostazioni della classe aggiornate con successo.');
    }

    /**
     * Delete the class
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Classe eliminata con successo.');
    }
}
