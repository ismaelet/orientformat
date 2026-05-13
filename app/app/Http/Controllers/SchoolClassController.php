<?php

namespace App\Http\Controllers;

use App\Models\Activities\Section;
use App\Models\Results\User\SectionResult;
use App\Models\Results\User\TestResult;
use App\Models\Schools\SchoolClass;

class SchoolClassController extends Controller {

    /**
     * Show the class dashboard
     */
    public function show(SchoolClass $class) {
        $students = $class->students->load('user');
        $studentCount = $students?->count() ?: 0;

        $sectionCount = Section::where('isStandard', true)
            ->where('active', true)
            ->whereHas('grades', function ($query) use ($class) {
                $query->where('activities_grades.id', $class->grade()->absolute_number);
            })
            ->count() ?: 0;

        $progressCount = SectionResult::where('completed', true)
            ->whereIn('studentId', $students->pluck('userId'))
            ->whereIn(
                'sectionId',
                Section::where('isStandard', true)
                    ->where('active', true)
                    ->whereHas('grades', function ($query) use ($class) {
                        $query->where('activities_grades.id', $class->grade()->absolute_number);
                    })
                    ->pluck('id')
            )
            ->count() ?: 0;

        $maxProgressCount = $sectionCount * $studentCount;
        $progressPercent = $maxProgressCount ? round($progressCount / $maxProgressCount * 100) : 0;

        // feed
        $maxFeedCount = round(0.6 * $studentCount);
        $feed = [];
        $feedEntriesData = $studentCount ? TestResult::query()
            ->select('studentId', 'testId')
            ->whereIn('studentId', $students->pluck('userId'))
            ->whereHas('test')
            ->orderBy('time', 'desc')
            ->with('student', 'student.user', 'test')
            ->limit($maxFeedCount)
            ->get() : null;

        if ($feedEntriesData) {
            foreach ($feedEntriesData as $feedEntryData) {
                $feedEntry = [];

                $feedEntry['studentName'] = $feedEntryData->student->full_name;
                $feedEntry['text'] = 'ha completato l\'attività "<i>' . $feedEntryData->test->title . '</i>"';

                $feed[] = $feedEntry;
            }
        }

        return view('class.show', [
            'class' => $class,
            'students' => $students,
            'studentCount' => $studentCount,
            'progressPercent' => $progressPercent,
            'feed' => $feed,
            'feedEntriesData' => $feedEntriesData,
        ]);
    }

    /**
     * Show the list of students for the results
     */
    public function studentResultsIndex(SchoolClass $class) {
        $class->load('students', 'students.user');

        return view('class.students.results.index', [
            'class' => $class,
        ]);
    }
}
