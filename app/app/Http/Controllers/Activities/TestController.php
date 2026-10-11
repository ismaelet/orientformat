<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;
use App\Models\Results\User\AdditionalResult;
use App\Models\Results\User\TestResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Legacy\Exceptions\LegacyRedirectException;
use App\Legacy\Logic;
use Legacy\Activity\Test as LegacyTest;
use Legacy\LogicManager\TestLogic;

class TestController extends Controller {

    /**
     * Display the specified resource
     */
    function show(Test $test) {
        // Access check
        if (is_student()) {
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

        if (!in_array($test->template, ['blade', 'survey'])) {
            try {
                return \App\Legacy\LegacyView::setPage($page)
                    ->setTemplate($template)
                    ->setTitle($title)
                    ->set('test', $test)
                    ->show();
            } catch (LegacyRedirectException $e) {
                return redirect()->to($e->url);
            }
        }

        // Blade view handling
        // dd($test->helperClass());
        $helper = $test->helper();
        $student = legacy_watched_student();
        $completed = $student->hasCompletedTest($test);
        $resultObj = $student->testResult($test);

        $data = [
            'test' => $test,
            'title' => $title,
            'student' => $student,
            'completed' => $completed,
            'result' => $resultObj?->results(),
            'percentage' => $resultObj?->percentage,
            'helper' => $helper,
            'survey' => $test->survey,
        ];

        if ($helper && method_exists($helper, 'viewData')) {
            $data = array_merge(
                $data,
                $helper->viewData($test, $student, $resultObj)
            );
        }

        return view($test->view(), $data);
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request, Test $test): RedirectResponse {
        $student = student();

        // Handle legacy templates separately
        if (!in_array($test->template, ['blade', 'survey'], true)) {
            return $this->storeLegacy($request, $test);
        }

        $helper = $test->helper();

        // Allow custom test submission handling
        if ($helper && method_exists($helper, 'store')) {
            return $helper->store($request, $test, $student);
        }

        // Default submission handling
        $fields = $request->input('field', []);
        $timePassed = $request->integer('speed', 0);

        $test->storeResult(
            student: $student,
            fields: $fields,
            timePassed: $timePassed,
            request: $request
        );

        return redirect()->to($test->nextUrl($student));
    }

    /**
     * Store the result of a legacy test submission
     */
    private function storeLegacy(
        Request $request,
        Test $test
    ): RedirectResponse {
        $student = student();
        $legacyTest = new LegacyTest($test->id);

        // Handle redo separately
        if ($request->has('redo')) {
            $redoTest = new LegacyTest($request->integer('redo'));

            $redoTest->redo();

            $modernRedoTest = Test::findOrFail($redoTest->id);

            return redirect()->to($modernRedoTest->url());
        }

        // Initialize legacy test logic
        try {
            Logic::add($test->template, 'template');
            Logic::add($test->filePath(), 'page');
            Logic::load();
        } catch (LegacyRedirectException $e) {
            return redirect()->to($e->url);
        }

        // No normal submission handling for test-next templates
        if ($test->template === 'test-next') {
            return redirect()->to($test->url());
        }

        // A completed test should advance without saving again
        if ($legacyTest->completed) {
            return redirect()->to($test->nextUrl($student));
        }

        // Get submitted fields
        $fields = $request->input('field', []);

        // Calculate score using the callback registered by the legacy logic
        $score = TestLogic::$legacyTestSubmitFunction
            ? TestLogic::runTestSubmitFunction()
            : 100;

        // Save result
        $legacyTest->saveResult(
            implode(',', $fields),
            $score,
            !$request->has('skip'),
            $request->integer('speed', 0)
        );

        // Review should reload the same test
        if ($request->has('review')) {
            return redirect()->to($test->url());
        }

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

        $additionalResult = AdditionalResult::where('studentId', $user->id)
            ->where('testId', $test->id)
            ->first();

        if ($additionalResult) {
            $additionalResult->delete();
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

        $firstDependentTest = $dependentTests?->first();

        return redirect()->to(
            $firstDependentTest?->url() ?? $test->url()
        );
    }


    /**
     * Download the answers for a survey test as a PDF file
     */
    public function downloadAnswers(Test $test): Response {
        // Only survey tests
        abort_unless($test->template === 'survey', 404);

        // Current student, or student resolved by your simulation helper
        $student = student();

        abort_unless($student, 403);

        // Retrieve the latest completed result for this student
        $testResult = $student->test_results()
            ->where('testId', $test->id)
            ->where('completed', true)
            ->orderByDesc('id')
            ->firstOrFail();

        // Temporarily reuse the legacy survey definition
        $survey = $test->survey()
            ->with('questions')
            ->firstOrFail();

        // Modern test results store comma-separated answers
        $rawAnswers = $testResult->getRawOriginal('result');

        $answers = $rawAnswers !== null
            ? explode(',', $rawAnswers)
            : [];

        // Prepare the questions and answers
        $questions = [];

        foreach ($survey->questions as $index => $question) {
            $answerIndex = $answers[$index] ?? null;

            $questions[] = [
                'text' => $question->text,
                'answer' => $answerIndex !== null
                    ? ($survey->answers[$answerIndex] ?? '-')
                    : '-',
            ];
        }

        // Only show the student name when using teacher simulation
        $showStudentName = is_teacher_or_administrator();

        // Generate PDF
        $pdf = Pdf::loadView('pdf.survey-answers', [
            'test' => $test,
            'student' => $student,
            'showStudentName' => $showStudentName,
            'questions' => $questions,
        ])->setPaper('a4', 'portrait');

        // Generate filename
        $filename = 'Risposte_' . Str::slug(
            $test->name,
            '_'
        ) . '.pdf';

        return $pdf->download($filename);
    }
}
