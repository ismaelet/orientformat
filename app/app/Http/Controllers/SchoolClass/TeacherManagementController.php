<?php

namespace App\Http\Controllers\SchoolClass;

use App\Models\Schools\SchoolClass;
use Legacy\Http\Request;

class TeacherManagementController
{
    /**
     * Display the teacher management dashboard
     */
    public function index(Request $request, SchoolClass $class)
    {
        $teacher = teacher();

        return view('class.teachers.index', [
            'class' => $class,
            'teacher' => $teacher,
        ]);
    }
}
