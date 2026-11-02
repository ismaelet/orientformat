<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Activities\Area;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassProgressController extends Controller
{
    /**
     * Display the progress of a specific class
     */
    public function index(Request $request, SchoolClass $class)
    {
        $startingGrade = $class->isHighSchool() ? 4 : 1;
        $currentGrade = $class->grade;
        $grades = Grade::where('absolute_number', '>=', $startingGrade)
            ->where('absolute_number', '<=', $currentGrade)
            ->where('is_professional', $class->isProfessional())
            ->orderByDesc('absolute_number')
            ->with('areas')
            ->get();

        return view('class.progress.index', [
            'class' => $class,
            'grades' => $grades,
        ]);
    }

    /**
     * Display the progress of a area of specific class
     */
    public function show(Request $request, SchoolClass $class, Area $area)
    {
        $grade = Grade::find($request->input('grade'));
        $sections = $grade->completable_sections->where('areaId', $area->id);
        $students = $class->active_students->load('user', 'section_results')->sortBy('inverted_full_name');

        return view('class.progress.show', [
            'area' => $area,
            'class' => $class,
            'sections' => $sections,
            'students' => $students,
        ]);
    }
}
