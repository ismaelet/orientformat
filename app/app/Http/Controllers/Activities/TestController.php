<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller {

    /**
     * Display the specified resource
     */
    function show(Test $test) {
        // Access check
        if (!is_student()) {
            $availableGrades = student()->availableGrades();
            $sectionGrades = $test->section->grades;

            if (!$availableGrades->pluck('id')->intersect($sectionGrades->pluck('id'))->count()) {
                return redirect()->route('activities.grades.index');
            }
        }

        // Legacy view handling
        $page = $test->filePath();
        $template = $test->template;
        $title = $test->name;

        if ($test->template != 'blade') {
            return \App\Legacy\LegacyView::setPage($page)
                ->setTemplate($template)
                ->setTitle($title)
                ->set('test', $test)
                ->show();
        }

        // Blade view handling
        $helper = $test->helperClass();
        $student = legacy_watched_student();
        $completed = $student->hasCompletedTest($test);
        $resultObj = $student->testResult($test);

        return view($test->view(), [
            'test' => $test,
            'title' => $title,
            'student' => $student,
            'completed' => $completed,
            'result' => $resultObj?->results(),
            'helper' => $helper,
        ]);
    }

    /**
     * Store a newly created resource in storage
     */
    function store(Request $request, Test $test): RedirectResponse {
        $student = student();
        $fields = $request->input('field', []);
        $timePassed = $request->input('speed', 0);
        $test->storeResult(student: $student, fields: $fields, timePassed: $timePassed);

        return redirect()->to($test->nextUrl($student));
    }

    /**
     * Reset the specified resource
     */
    function reset(Test $test): RedirectResponse {
        $user = Auth::user();

        $testResult = TestResult::where('studentId', $user->id)
            ->where('testId', $test->id)
            ->first();

        if ($testResult) {
            $testResult->delete();
        }

        return redirect()->to($test->url());
    }

    /**
     * Reset all the dependent tests
     */
    function resetDependent(Test $test): RedirectResponse {
        $user = Auth::user();
        $dependentTests = $test->dependent_tests()?->sortBy('step');

        // Delete dependent test results
        $dependentTests->each(function (Test $dependentTest) use ($user) {
            $testResult = TestResult::where('studentId', $user->id)
                ->where('testId', $dependentTest->id)
                ->first();

            if ($testResult) {
                $testResult->delete();
            }
        });

        // Delete main test result
        $testResult = TestResult::where('studentId', $user->id)
            ->where('testId', $test->id)
            ->first();

        if ($testResult) {
            $testResult->delete();
        }

        $firstDependentTest = $dependentTests->first();

        return redirect()->to($firstDependentTest?->url());
    }
}
