<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Schools\Grade;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller {

    /**
     * Display a listing of the available grades
     */
    function index() {
        $student = Auth::user()->student;
        $class = $student->class;

        if ($class) {
            $grades = Grade::where('is_professional', $class->isProfessional())
                ->where('absolute_number', '>=', $class->first_grade)
                ->where('absolute_number', '<=', $class->grade)
                ->orderBy('absolute_number')
                ->with('completable_sections')
                ->get();
        }

        return view('activities.grades.index', [
            'class' => $class,
            'student' => $student,
            'grades' => $grades ?? collect(),
        ]);
    }

    /**
     * Display the sections of a specific grade
     */
    function show(Grade $grade) {
        $grade->load('areas', 'areas.sections', 'sections.tests', 'sections.tests.section', 'sections.active_tests', 'sections.main_section');
        $student = Auth::user()->student;

        session()->put('activities-year', $grade->absolute_number);

        return view('activities.grades.show', [
            'grade' => $grade,
            'student' => $student,
        ]);
    }
}
