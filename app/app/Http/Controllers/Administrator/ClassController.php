<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource
     */
    public function index(Request $request)
    {
        $school = administrator()->school->load('teachers.user');

        return view('administrator.classes', [
            'school' => $school,
        ]);
    }
}
