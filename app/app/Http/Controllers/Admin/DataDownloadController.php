<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\Request;

class DataDownloadController extends Controller {

    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Property: Download only active students
     */
    public bool $activeStudents = false;
    /**
     * Property: The list of grades, to avoid querying the database multiple times when generating rows
     */
    public Collection $grades;

    /**
     * Property: Grades indexed by a composite key of absolute number and professional status, to avoid searching for the right grade when generating rows
     */
    public array $gradesByKey;

    /**
     * Property: The list of tests, to avoid querying the database multiple times when generating rows
     */
    public Collection $tests;

    /**
     * Property: Tests indexed by the same composite key of the grade, to avoid searching for the right tests when generating rows
     */
    public array $testsByGradeKey;

    /**
     * Property: The list of test IDs, to avoid querying the database multiple times when generating rows
     */
    public array $testIds;

    /**
     * Property: The list of reviews, to avoid querying the database multiple times when generating rows
     */
    public Collection $reviews;

    /**
     * Property: The list of review questions, to avoid querying the database multiple times when generating rows
     */
    public Collection $reviewQuestions;

    /**
     * Property: Review questions indexed by review ID, to optimize lookups when generating rows
     */
    public array $reviewQuestionsByReview = [];

    /**
     * Property: The review data (columns related to reviews), to avoid querying the database multiple times when generating rows
     */
    public SupportCollection $reviewData;

    /**
     * Property: Review columns indexed by review ID, to optimize lookups when generating rows
     */
    public array $reviewColumnsByReview = [];

    /**
     * Action: Download data based on selected parameters
     */
    public function details() {
        set_time_limit(300);

        $fileName = 'Lista_Studenti_' . now()->format('Ymd_His') . '.csv';

        /**
         * Stream the CSV download response
         */
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            // start building the student query
            $studentsQuery = $this->baseStudentQuery();

            // filter by year
            $studentsQuery = $this->filterBySchoolYear($studentsQuery, $this->schoolYear, $this->activeStudents);

            // filter by school type
            $studentsQuery = $this->filterBySchoolType($studentsQuery, $this->schoolType);

            // generate the list of test results and related columns
            $this->tests = Test::query()
                ->with('section')
                ->whereHas('section', function ($q) {
                    $q->where('active', true);
                    $q->where('isStandard', true);
                })
                ->orderBy('areaId')
                ->orderBy('sectionId')
                ->get();

            $this->testIds = $this->tests->pluck('id')->all();

            // generate the list of resources to avoid N+1 queries when generating rows
            $this->grades = Grade::with('sections')->get();
            $this->gradesByKey = $this->buildGradesByKey();
            $this->testsByGradeKey = $this->buildTestsByGradeKey();
            $this->reviews = $this->reviewsForStudents($studentsQuery, $this->schoolType);
            $this->reviewQuestions = $this->questionsForReviews($this->reviews);
            $this->reviewQuestionsByReview = $this->buildReviewQuestionsByReview();
            $this->reviewData = $this->buildReviewData();

            $this->reviewColumnsByReview = $this->reviewData
                ->groupBy('review_id')
                ->map(fn($group) => $group->values()->all())
                ->all();

            // generate the table header
            $tableHeader = array_merge(
                $this->baseColumns(),
                $this->testColumns(),
                $this->reviewColumns(),
            );

            fputcsv($out, $tableHeader);

            $studentsQuery->chunkById(200, function ($studentsChunk) use (
                $out,
            ) {

                // generate the test restults for the current chunk of students (it gives problems if we do it outside the chunk, because of memory limits)
                $studentIds = $studentsChunk->pluck('id')->all();

                $testResults = $this->testResults($studentIds);
                $reviewResults = $this->reviewResults($studentIds);

                foreach ($studentsChunk as $student) {
                    $studentTestResults = $testResults->get($student->id, collect())->keyBy('testId');
                    $studentReviewResults = $reviewResults->get($student->id, collect())->keyBy('reviewId');

                    $this->writeStudentRows(
                        $out,
                        $student,
                        $studentTestResults,
                        $studentReviewResults,
                    );
                }
            });

            fclose($out);
        }, $fileName);
    }

    /**
     * Helper: Build the base student query with necessary relationships
     */
    private function baseStudentQuery(): Builder {
        return Student::query()
            ->with(['user', 'class.school', 'class.grade_level'])
            ->orderBy('id');
    }

    /**
     * Helper: Apply school year filter to the query, optionally limiting to  students active in that year
     */
    private function filterBySchoolYear(Builder $query, ?int $year, bool $onlyActiveStudents): Builder {
        // if no year is selected, return the unfiltered query
        if (!$year) {
            return $query;
        }

        $startDate = now()->setDate($year, 9, 1)->startOfDay();
        $endDate   = now()->setDate($year + 1, 8, 31)->endOfDay();

        // if only active students are requested, filter to those with test results in the date range
        if ($onlyActiveStudents) {
            return $query->whereHas('test_results', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }

        // otherwise, filter students whose registration date falls within the date range
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Helper: Apply school type filter to the query
     */
    private function filterBySchoolType(Builder $query, string $schoolType): Builder {
        if ($schoolType == 'all') {
            return $query;
        }

        return $query->whereHas(
            'class.grade_level',
            fn($q) =>
            $q->where('is_highschool', $schoolType === 'highschool')
        );
    }

    /**
     * Helper: Build an associative array of grades indexed by a composite key of absolute number and professional status, to optimize lookups when generating rows
     */
    private function buildGradesByKey(): array {
        $gradesByKey = [];

        foreach ($this->grades as $grade) {
            $gradeKey = $this->gradeKey($grade->absolute_number, $grade->is_professional);
            $gradesByKey[$gradeKey] = $grade;
        }

        return $gradesByKey;
    }

    /**
     * Helper: Build an associative array of test IDs indexed by the same composite key of the grade, to optimize lookups when generating rows
     */
    private function buildTestsByGradeKey(): array {
        $testsByGradeKey = [];

        foreach ($this->grades as $grade) {
            $gradeKey = $this->gradeKey($grade->absolute_number, $grade->is_professional);

            $sectionIds = $grade->sections->pluck('id')->all();

            $testsByGradeKey[$gradeKey] = $this->tests
                ->whereIn('sectionId', $sectionIds)
                ->pluck('id')
                ->all();
        }

        return $testsByGradeKey;
    }

    /**
     * Helper: Get a list of base columns for the CSV export
     */
    private function baseColumns(): array {
        return ['ID', 'Cognome', 'Nome',  'Classe', 'Anno di corso', 'Anno scolastico', 'Scuola', 'È superiore'];
    }

    /**
     * Helper: Get a list of columns for the test results, based on the selected tests
     */
    private function testColumns(): array {
        return $this->tests->map(function ($test) {
            $safeName = str_replace([',', ';', '.'], '-', $test->section->name . ' > ' . $test->name);
            return 'Risultato ' . $safeName;
        })->all();
    }

    /**
     * Helper: Get review results for the given students, grouped by student ID
     */
    private function reviewResults(array $studentIds): SupportCollection {
        return ReviewResult::query()
            ->select(['studentId', 'reviewId', 'results'])
            ->whereIn('studentId', $studentIds)
            ->get()
            ->groupBy('studentId');
    }

    /**
     * Helper: Get a list of columns for the review results, based on the reviews completed by the selected students and the questions related to those reviews
     */
    private function buildReviewData(): SupportCollection {
        $reviewNames = [
            1 => 'Questionario iniziale medie (vecchio)',
            2 => 'Questionario iniziale medie',
            3 => 'Questionario finale medie',
            4 => 'Primo questionario iniziale superiori',
            5 => 'Altro questionario iniziale superiori',
            6 => 'Questionario finale superiori',
        ];

        $flatQuestions = collect();

        foreach ($this->reviews as $review) {
            $questions = $this->reviewQuestionsByReview[$review->id] ?? collect();

            foreach ($questions as $question) {
                if ($question->optionCount() > 1) {
                    for ($optionKey = 1; $optionKey <= $question->optionCount(); $optionKey++) {
                        $questionFullSlug = $question->full_slug . '_' . $optionKey;

                        $flatQuestions->push(
                            [
                                'label' => $reviewNames[$review->id] . ' > ' . $questionFullSlug,
                                'slug' => $questionFullSlug,
                                'review_id' => $review->id,
                            ]
                        );
                    }
                } else {
                    $flatQuestions->push([
                        'label' => $reviewNames[$review->id] . ' > ' . $question->full_slug,
                        'slug' => $question->full_slug,
                        'review_id' => $review->id
                    ]);
                }
            }
        }

        return $flatQuestions;
    }

    /**
     * Helper: Build an associative array of review questions indexed by review ID, to optimize lookups when generating rows
     */
    private function buildReviewQuestionsByReview(): array {
        $map = [];

        foreach ($this->reviewQuestions as $question) {
            foreach ($question->reviews as $review) {
                $map[$review->id] ??= collect();
                $map[$review->id]->push($question);
            }
        }

        return $map;
    }

    /**
     * Helper: Get a list of columns for the review results
     */
    private function reviewColumns(): array {
        return $this->reviewData->pluck('label')->all();
    }

    /**
     * Helper: Get reviews completed by the given students
     */
    private function reviewsForStudents(Builder $studentsQuery, string $schoolType): Collection {
        return Review::query()
            ->whereHas('review_results', function ($q) use ($studentsQuery) {
                $q->whereIn('studentId', (clone $studentsQuery)->select('id'));
            })
            ->when($schoolType !== 'all', function ($q) use ($schoolType) {
                $reviewIds = $schoolType === 'highschool' ? [4, 5, 6] : [1, 2, 3];
                $q->whereIn('id', $reviewIds);
            })
            ->orderBy('id')
            ->get();
    }

    /**
     * Helper: Get all questions related to the given reviews
     */
    private function questionsForReviews(Collection $reviews): Collection {
        return ReviewQuestion::query()
            ->whereHas('reviews', function ($q) use ($reviews) {
                $q->whereIn('reviews.id', $reviews->pluck('id'));
            })
            ->with('reviews')
            ->orderBy('full_slug')
            ->get();
    }

    /**
     * Helper: Get test results for the given students and tests, grouped by student ID
     */
    private function testResults(array $studentIds): Collection {
        return TestResult::query()
            ->select(['studentId', 'testId', 'result'])
            ->whereIn('studentId', $studentIds)
            ->whereIn('testId', $this->testIds)
            ->get()
            ->groupBy('studentId');
    }

    /**
     * Helper: Generate CSV rows for a student, including one row per grade level they were registered in
     */
    private function writeStudentRows($out, Student $student, SupportCollection $studentTestResults, SupportCollection $studentReviewResults): void {
        $class = $student->class;

        if (!$class) {
            return;
        }

        $startGrade = $class->startingGrade;
        $lastPassedGrade = min($class->current_grade, $class->last_grade);
        $isProfessional = $class->isProfessional();

        for ($gradeNumber = $startGrade; $gradeNumber <= $lastPassedGrade; $gradeNumber++) {
            $gradeKey = $this->gradeKey($gradeNumber, $isProfessional);
            $grade = $this->gradesByKey[$gradeKey] ?? null;

            if (!$grade) {
                continue;
            }

            $testInGrade = $this->testsByGradeKey[$gradeKey] ?? [];

            $row = array_merge(
                $this->generateBaseStudentData($student, $grade),
                $this->generateStudentTestResults($testInGrade, $studentTestResults),
                $this->generateStudentReviewResults($studentReviewResults)
            );

            fputcsv($out, $row);
        }
    }

    /**
     * Helper: Generate a composite key for grades based on absolute number and professional status
     */
    private function gradeKey(int $absoluteNumber, bool $isProfessional): string {
        return $absoluteNumber . '_' . (int) $isProfessional;
    }

    /**
     * Helper: Generate the base student data for a specific grade
     */
    private function generateBaseStudentData(Student $student, Grade $grade): array {
        $class = $student->class;
        $startGrade = $class->startingGrade;
        $startYear = $class->startingYear;
        $gradeString = $grade->relative_number;
        $year = $startYear + ($grade->absolute_number - $startGrade);
        $yearString = $year . '-' . ($year + 1);

        return [
            $student->id,
            $student->user->last_name,
            $student->user->first_name,
            $class->nameInGrade($grade->absolute_number),
            $gradeString,
            $yearString,
            $class->school?->name ?? '.',
            $grade->is_highschool ? 'Sì' : 'No',
        ];
    }

    /**
     * Helper: Generate test result data for a student
     */
    private function generateStudentTestResults(array $testInGrade, SupportCollection $studentTestResults): array {
        $resultData = [];
        $testInGradeLookup = array_flip($testInGrade);

        foreach ($this->tests as $test) {
            if (!isset($testInGradeLookup[$test->id])) {
                $resultData[] = '.';
                continue;
            }

            $resultObj = $studentTestResults->get($test->id);

            $resultData[] = $resultObj
                ? (str_replace([',', ';', '.'], '-', implode('-', $resultObj->results())) ?: '.')
                : '.';
        }

        return $resultData;
    }

    private function generateStudentReviewResults(SupportCollection $studentReviewResults): array {
        $row = [];

        foreach ($this->reviewColumnsByReview as $reviewId => $columns) {
            $reviewResult = $studentReviewResults->get($reviewId);

            if (!$reviewResult) {
                foreach ($columns as $_column) {
                    $row[] = '.';
                }
                continue;
            }

            $resultsArray = $reviewResult->results();

            foreach ($columns as $column) {
                $row[] = $resultsArray[$column['slug']] ?? '.';
            }
        }

        return $row;
    }
}
