<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\ReviewResult;
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

        /**
         * Reviews list
         */
        $reivewNames = [
            1 => 'Questionario iniziale medie (vecchio)',
            2 => 'Questionario iniziale medie',
            3 => 'Questionario finale medie',
            4 => 'Primo questionario iniziale superiori',
            5 => 'Altro questionario iniziale superiori',
            6 => 'Questionario finale superiori',
        ];

        $studentIds = (clone $studentsQuery)->pluck('id');

        $reviews = Review::query()
            ->whereHas('review_results', function ($q) use ($studentIds) {
                $q->whereIn('studentId', $studentIds);
            })
            ->when($this->schoolType != 'all', function ($q) {
                $reviewIds = $this->schoolType === 'highschool' ? [4, 5, 6] : [1, 2, 3];
                $q->whereIn('id', $reviewIds);
            })
            ->orderBy('id')
            ->get();

        $reviewQuestions = ReviewQuestion::query()
            ->whereHas('reviews', function ($q) use ($reviews) {
                $q->whereIn('reviews.id', $reviews->pluck('id'));
            })
            ->with('reviews')
            ->orderBy('full_slug')
            ->get();

        $flatQuestions = collect();

        foreach ($reviews as $review) {
            $questions = $reviewQuestions->filter(fn($q) => $q->reviews->contains('id', $review->id));

            foreach ($questions as $question) {
                if ($question->optionCount() > 1) {
                    for ($optionKey = 1; $optionKey <= $question->optionCount(); $optionKey++) {
                        $questionFullSlug = $question->full_slug . '_' . $optionKey;

                        $flatQuestions->push(
                            [
                                'label' => $reivewNames[$review->id] . ' > ' . $questionFullSlug,
                                'slug' => $questionFullSlug,
                                'review_id' => $review->id,
                            ]
                        );
                    }
                } else {
                    $flatQuestions->push([
                        'label' => $reivewNames[$review->id] . ' > ' . $question->full_slug,
                        'slug' => $question->full_slug,
                        'review_id' => $review->id
                    ]);
                }
            }
        }

        /**
         * Stream the CSV download response
         */
        return response()->streamDownload(function () use (
            $studentsQuery,
            $tests,
            $testColumns,
            $yearColName,
            $startDate,
            $endDate,
            $flatQuestions,
            $reviews
        ) {
            $out = fopen('php://output', 'w');

            $baseHeader = ['ID', 'Cognome', 'Nome', 'Classe', 'Scuola', 'Scuola superiore', $yearColName, 'Anno di fine corso', 'Registrato/a il'];
            $fullHeader = array_merge($baseHeader, array_values($testColumns), $flatQuestions->pluck('label')->all());
            fputcsv($out, $fullHeader);

            // ✅ Precompute per-review question slugs once
            $questionSlugsByReview = $flatQuestions
                ->groupBy('review_id')
                ->map(fn($items) => $items->pluck('slug')->values());

            $activeStudents = $this->activeStudents; // don't rely on $this inside deep closures

            $studentsQuery->chunkById(500, function ($studentsChunk) use (
                $out,
                $tests,
                $startDate,
                $endDate,
                $reviews,
                $questionSlugsByReview,
                $activeStudents
            ) {
                $studentIds = $studentsChunk->pluck('id')->all();

                // ✅ Test results: one query
                $testResultsQuery = TestResult::query()->whereIn('studentId', $studentIds);

                if ($startDate && $endDate && $activeStudents) {
                    $testResultsQuery->whereBetween('created_at', [$startDate, $endDate]);
                }

                $testResultsByStudent = $testResultsQuery->get()->groupBy('studentId');

                // ✅ Review results: one query
                $reviewResultsByStudent = ReviewResult::query()
                    ->whereIn('studentId', $studentIds)
                    ->whereIn('reviewId', $reviews->pluck('id'))
                    ->get()
                    ->groupBy('studentId');

                foreach ($studentsChunk as $student) {
                    $gradeLevel = $this->schoolYear
                        ? $student->class?->gradeLevelAt($this->schoolYear)
                        : $student->class?->grade_level;

                    if ($this->courseYear && ($gradeLevel?->school_relative_number ?? null) != $this->courseYear) {
                        continue;
                    }

                    $row = [
                        $student->id,
                        $student->user->last_name,
                        $student->user->first_name,
                        $student->class?->name ?? '.',
                        $student->class?->school?->name ?? '.',
                        $student->class?->grade_level?->is_highschool ? 'Sì' : 'No',
                        $this->schoolYear ? 'Anno di corso nel ' . $this->schoolYear : 'Anno di corso' => $gradeLevel?->school_relative_number ?? '.',
                        $student->class?->ended ? $student->class?->lastActiveYear() : '.',
                        $student->created_at->format('d/m/Y'),
                    ];

                    // Test results O(1)
                    $studentTestResults = ($testResultsByStudent[$student->id] ?? collect())->keyBy('testId');

                    foreach ($tests as $test) {
                        $resultObj = $studentTestResults->get($test->id);

                        $row[] = $resultObj
                            ? (str_replace([',', ';', '.'], '-', implode('-', $resultObj->results())) ?: '.')
                            : '.';
                    }

                    // Review results O(1)
                    $studentReviewResults = ($reviewResultsByStudent[$student->id] ?? collect())->keyBy('reviewId');

                    foreach ($reviews as $review) {
                        $reviewResult = $studentReviewResults->get($review->id);

                        $slugs = $questionSlugsByReview->get($review->id, collect());

                        if (!$reviewResult) {
                            // no result: fill dots for that review
                            foreach ($slugs as $_slug) {
                                $row[] = '.';
                            }
                            continue;
                        }

                        $resultsArray = $reviewResult->results(); // should return array

                        foreach ($slugs as $slug) {
                            $row[] = $resultsArray[$slug] ?? '.';
                        }
                    }

                    fputcsv($out, $row);
                }
            });

            fclose($out);
        }, $fileName);
    }
}
