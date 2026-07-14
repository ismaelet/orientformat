<?php

namespace App\Console\Commands;

use App\Models\Activities\Section;
use App\Models\User\Student;
use App\Services\Results\StudentSectionResultCalculator;
use App\Support\GraphSections;
use Illuminate\Console\Command;
use Legacy\Activity\Result\Handler\StudentSectionResult;
use Throwable;

class CompareSectionResults extends Command {
    protected $signature = 'results:compare-legacy
    {--limit=100 : Maximum number of students}
    {--section= : Compare only one section}
    {--student= : Compare only one student}
    {--detailed : Compare detailed section results}
    {--all : Compare all matching students}';

    protected $description =
    'Compare modern and legacy section result calculations';

    public function handle(
        StudentSectionResultCalculator $calculator,
    ): int {
        $_SERVER['REMOTE_ADDR'] ??= '127.0.0.1';

        $sectionIds = $this->option('section')
            ? [(int) $this->option('section')]
            : GraphSections::ids();

        $studentsQuery = Student::query()
            ->orderBy('id');

        if ($this->option('student')) {
            $studentsQuery->whereKey(
                (int) $this->option('student'),
            );
        } else if (!$this->option('all')) {
            $studentsQuery->limit(
                (int) $this->option('limit'),
            );
        }

        $sections = Section::query()
            ->with('active_tests')
            ->whereIn('id', $sectionIds)
            ->get()
            ->keyBy('id');

        $checked = 0;
        $mismatches = 0;
        $errors = 0;
        $legacyErrors = 0;

        foreach ($sectionIds as $sectionId) {
            $section = $sections->get($sectionId);

            if (!$section) {
                $this->warn(
                    "Section [{$sectionId}] was not found.",
                );

                continue;
            }

            $this->info("Comparing section {$sectionId}...");

            $query = Student::query()
                ->orderBy('id');

            if ($this->option('student')) {
                $query->whereKey(
                    (int) $this->option('student'),
                );
            } elseif (!$this->option('all')) {
                $query->limit(
                    (int) $this->option('limit'),
                );
            }

            $query->chunkById(
                250,
                function ($students) use (
                    $calculator,
                    $section,
                    $sectionId,
                    &$checked,
                    &$mismatches,
                    &$errors,
                    &$legacyErrors,
                ): void {
                    $calculator->clearPreloadedResults();

                    foreach ($students as $student) {
                        try {
                            $modernResult = $this->option('detailed')
                                ? $calculator->detailedResult(
                                    section: $section,
                                    student: $student,
                                )
                                : $calculator->result(
                                    section: $section,
                                    student: $student,
                                );
                        } catch (Throwable $exception) {
                            $errors++;

                            $this->error(
                                "Modern error: section {$sectionId}, student {$student->id}",
                            );

                            $this->line($exception->getMessage());

                            if ($this->output->isVerbose()) {
                                $this->line(
                                    "{$exception->getFile()}:{$exception->getLine()}",
                                );
                            }

                            continue;
                        }

                        try {
                            $legacyCalculator =
                                new StudentSectionResult(
                                    $section->id,
                                    $student->id,
                                )->ignoreStaticResult()
                                ->withoutPersistingResult();

                            $legacyResult =
                                $this->option('detailed')
                                ? $legacyCalculator->detailedResult
                                : $legacyCalculator->result;
                        } catch (Throwable $exception) {
                            $legacyErrors++;

                            if ($this->output->isVerbose()) {
                                $this->warn(
                                    "Legacy error: section {$sectionId}, student {$student->id}",
                                );

                                $this->line(
                                    'Modern result: '
                                        . $this->format($modernResult),
                                );

                                $this->line(
                                    'Legacy error: '
                                        . $exception->getMessage(),
                                );
                            }

                            continue;
                        }

                        $checked++;

                        if (
                            $this->normalize($modernResult)
                            !== $this->normalize($legacyResult)
                        ) {
                            $mismatches++;

                            $this->error(
                                "Mismatch: section {$sectionId}, student {$student->id}",
                            );

                            $this->line(
                                'Modern: '
                                    . $this->format($modernResult),
                            );

                            $this->line(
                                'Legacy: '
                                    . $this->format($legacyResult),
                            );
                        }
                    }
                },
                column: 'id',
            );
        }

        $this->newLine();

        $this->table(
            [
                'Checked',
                'Mismatches',
                'Modern errors',
                'Legacy errors',
            ],
            [[
                $checked,
                $mismatches,
                $errors,
                $legacyErrors,
            ]],
        );

        return $mismatches === 0 && $errors === 0
            ? self::SUCCESS
            : self::FAILURE;
    }

    private function normalize(mixed $result): mixed {
        if (is_string($result)) {
            $result = trim($result);

            if (is_numeric($result)) {
                return str_contains($result, '.')
                    ? (float) $result
                    : (int) $result;
            }

            return $result;
        }

        if (is_array($result)) {
            $result = $this->normalizeArray($result);

            return $result === []
                ? null
                : $result;
        }

        return $result;
    }

    private function normalizeArray(array $result): array {
        foreach ($result as $key => $value) {
            $result[$key] = $this->normalize($value);
        }

        if ($this->isListOfTestResults($result)) {
            usort(
                $result,
                static fn(array $left, array $right): int =>
                strcmp(
                    (string) ($left['test'] ?? ''),
                    (string) ($right['test'] ?? ''),
                ),
            );
        }

        return $result;
    }

    private function isListOfTestResults(array $result): bool {
        if (!array_is_list($result) || $result === []) {
            return false;
        }

        foreach ($result as $item) {
            if (
                !is_array($item)
                || !array_key_exists('test', $item)
                || !array_key_exists('percentage', $item)
            ) {
                return false;
            }
        }

        return true;
    }

    private function format(mixed $result): string {
        return json_encode(
            $result,
            JSON_UNESCAPED_UNICODE
                | JSON_UNESCAPED_SLASHES,
        ) ?: 'null';
    }
}
