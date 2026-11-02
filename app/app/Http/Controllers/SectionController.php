<?php

namespace App\Http\Controllers;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Vite;

class SectionController extends Controller
{
    public function show(Section $section): View
    {
        $student = student();

        // Back URL
        if (is_teacher_or_administrator()) {
            $backUrl = route('teacher.simulation');
        } else {
            $gradeNumber = session()->get('activities-year')
                ?? legacy_student()->schoolClass->relativeGrade;

            $backUrl = route('activities.grades.show', $gradeNumber);
        }

        // Get the original/main section
        $section->loadMissing('main_section.area', 'area');
        $mainSection = $section->originalSection();

        // Modern cover image
        $modernImage = 'sections/recap-'.$mainSection->slug.'.webp';

        // Legacy cover image
        $legacyImage = '/pages/assets/'
            .$mainSection->area->slug
            .'/'
            .$mainSection->slug
            .'/recap/background.webp';

        // Determine which image to use
        if (file_exists(base_path('resources/images/'.$modernImage))) {
            $coverImage = Vite::image($modernImage);
        } elseif (file_exists(server_path($legacyImage))) {
            $coverImage = asset('legacy'.$legacyImage);
        } else {
            $coverImage = asset(
                'legacy'.str_replace(
                    'background.webp',
                    'bgr.png',
                    $legacyImage
                )
            );
        }

        // Tests belonging to this section
        $tests = Test::query()
            ->where('sectionId', $section->id)
            ->where('template', '!=', 'recap')
            ->where('active', true)
            ->with('section')
            ->orderBy('step')
            ->get();

        // Load results once
        $testResults = $student->test_results()
            ->whereIn('testId', $tests->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->groupBy('testId');

        $tests->each(function (Test $test) use ($testResults, $mainSection) {
            $results = $testResults->get($test->id, collect());

            $result = $results->first(
                fn ($result) => (bool) $result->completed
            );

            $test->setAttribute(
                'recap_completed',
                $result !== null
            );

            $test->setAttribute(
                'recap_percentage',
                $result?->percentage
            );

            $test->setAttribute(
                'recap_image',
                'tests/'.$mainSection->slug.'/recap/'.$test->slug
            );
        });

        return view('activities.sections.show', [
            'section' => $section,
            'tests' => $tests,
            'backUrl' => $backUrl,
            'coverImage' => $coverImage,
        ]);
    }
}
