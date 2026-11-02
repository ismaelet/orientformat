<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource
     */
    public function index(Request $request)
    {
        $school = administrator()->school;

        return view('administrator.teachers', [
            'school' => $school,
        ]);
    }
}
