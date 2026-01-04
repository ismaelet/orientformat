<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Details extends Component {

    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: Course year
     */
    public ?int $courseYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Property: Download only active students
     */
    public bool $activeStudents = false;

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render() {
        return view('livewire.admin.data-download.details');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData() {

        $data = [];

        $studentsQuery = Student::query()
            ->with(['user', 'class.school', 'class.grade_level'])
            ->orderBy('id');

        // Build date range once
        $startDate = $endDate = null;
        if ($this->schoolYear) {
            $startDate = now()->setDate($this->schoolYear, 9, 1)->startOfDay();
            $endDate   = now()->setDate($this->schoolYear + 1, 8, 31)->endOfDay();

            if ($this->activeStudents) {
                $studentsQuery->whereHas('test_results', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            } else {
                $studentsQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($this->schoolType !== 'all') {
            $studentsQuery->whereHas(
                'class.grade_level',
                fn($q) =>
                $q->where('is_highschool', $this->schoolType === 'highschool')
            );
        }

        // Tests list once
        $tests = Test::query()
            ->with('section')
            ->whereHas('section')
            ->orderBy('areaId')
            ->orderBy('sectionId')
            ->get();

        // Precompute headers/column names once
        $testColumns = [];
        foreach ($tests as $test) {
            $safeName = str_replace([',', ';', '.'], '-', $test->section->name . ' > ' . $test->name);
            $testColumns[$test->id] = 'Risultato ' . $safeName;
        }

        $yearColName = $this->schoolYear
            ? 'Anno di corso nel ' . $this->schoolYear
            : 'Anno di corso';

        $fileName = 'Lista_Studenti_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($studentsQuery, $tests, $testColumns, $yearColName, $startDate, $endDate) {
            $out = fopen('php://output', 'w');

            // Write header
            $baseHeader = ['ID', 'Cognome', 'Nome', 'Classe', 'Scuola', $yearColName, 'Registrato/a il'];
            $fullHeader = array_merge($baseHeader, array_values($testColumns));
            fputcsv($out, $fullHeader);

            $wroteAnyRow = false;

            $studentsQuery->chunkById(500, function ($studentsChunk) use ($out, $tests, $testColumns, $yearColName, $startDate, $endDate, &$wroteAnyRow) {
                $studentIds = $studentsChunk->pluck('id')->all();

                // Fetch ALL test results for this chunk in ONE query
                $testResultsQuery = TestResult::query()
                    ->whereIn('studentId', $studentIds);

                // If you ONLY care about results within the school year, also constrain here
                if ($startDate && $endDate && $this->activeStudents) {
                    $testResultsQuery->whereBetween('created_at', [$startDate, $endDate]);
                }

                // Keep select lean if possible (depends on your results() implementation)
                $testResults = $testResultsQuery->get()
                    ->groupBy('studentId');

                foreach ($studentsChunk as $student) {
                    $gradeLevel = $this->schoolYear
                        ? $student->class?->gradeLevelAt($this->schoolYear)
                        : $student->class?->grade_level;

                    if ($this->courseYear && ($gradeLevel?->school_relative_number ?? null) != $this->courseYear) {
                        continue;
                    }

                    $wroteAnyRow = true;

                    // Map testId => TestResult for O(1) lookup
                    $studentResults = ($testResults[$student->id] ?? collect())->keyBy('testId');

                    $row = [
                        $student->id,
                        $student->user->last_name,
                        $student->user->first_name,
                        $student->class?->name ?? '.',
                        $student->class?->school?->name ?? '.',
                        $gradeLevel?->school_relative_number ?? '.',
                        $student->created_at->format('d/m/Y'),
                    ];

                    foreach ($tests as $test) {
                        $resultObj = $studentResults->get($test->id);

                        $row[] = $resultObj
                            ? (str_replace([',', ';', '.'], '-', implode('-', $resultObj->results())) ?: '.')
                            : '.';
                    }

                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, $fileName);
    }
}
