<?php

use App\Models\Activities\Area;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use Illuminate\Support\Facades\Vite;

$legacySection = \App\Legacy\LegacyView::getInstance()->get('section');
$legacyArea = $legacySection->area;
$section = Section::find($legacySection->id);
$area = Area::find($legacyArea->id);
$student = student();

if (is_teacher_or_administrator()) {
    $backUrl = client_url('/teacher/simulation');
} else {
    $gradeNumber = session()->get('activities-year') ?? legacy_student()->schoolClass->relativeGrade;
    $backUrl = route('activities.grades.show', $gradeNumber);
}

$coverImage = file_exists(base_path('resources/images/sections/recap-' . $legacySection->mainSection->slug . '.webp')) ?
    Vite::image('sections/recap-' . $legacySection->mainSection->slug . '.webp') : (file_exists(server_path($file = '/pages/assets/' . $legacySection->mainSection->filePath . '/recap/background.webp')) ?
        asset('legacy' . $file) :
        asset('legacy' . str_replace('background.webp', 'bgr.png', $file)));

// Get tests
$tests = Test::where('sectionId', $section->id)
    ->where('template', '<>', 'recap')
    ->where('active', true)
    ->with('section')
    ->orderBy('step')
    ->get();

foreach ($tests as $test) {
    $testResult = $student->testResult($test);

    $test->completed = $testResult?->completed() ?? false;

    if ($testResult && $testResult->completed()) {
        $test->result_description = $testResult->percentage == 100 || $test->template == 'survey' ?
            __("Already completed")
            :
            __('Result') . ': <strong>' . $testResult->percentage . '%</strong>';
    } else {
        $test->result_description = __('Not completed');
    }

    $test->recap_image = 'tests/' . $legacySection->mainSection->slug . '/recap/' . $test->slug;
}

// download survey results
if (isset($_POST['download'])) {
    $test = Test::find($_POST['testId']);
    $testResult = $student->testResult($test);

    if ($testResult && $testResult->completed()) {
        print_survey_results($test->id, userId());
    }
}
