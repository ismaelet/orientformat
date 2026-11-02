<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;
use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class ProblemiSuperioriProblemGruppoHelper implements TestHelperInterface
{
    /**
     * Constant: Maximum score per question
     */
    public const int MAX_SCORE = 4;

    /**
     * Get the results for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function results(Test $test, Student|Teacher $user): Collection
    {
        $answers = $user->testResult($test)?->results() ?? [];
        $questions = self::questions();
        $roles = self::roles();

        $results = collect();

        foreach ($roles as $roleId => $roleName) {
            $roleQuestions = array_filter($questions, fn ($q) => $q['role'] === $roleId);
            $roleAnswers = array_intersect_key($answers, $roleQuestions);
            $score = array_sum($roleAnswers);
            $maxScore = count($roleQuestions) * self::MAX_SCORE;
            $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100) : 0;

            $results->push(collect([
                'id' => $roleId,
                'name' => $roleName,
                'description' => self::roleDescription($roleId),
                'answers' => $roleAnswers,
                'score' => $score,
                'percentage' => $percentage,
            ]));
        }

        return $results;
    }

    /**
     * Get the main roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function mainRoles(Test $test, Student|Teacher $user): Collection
    {
        $results = self::results($test, $user);
        $topScore = $results->max('score');

        return $results->where('score', $topScore);
    }

    /**
     * Get the other roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function otherRoles(Test $test, Student|Teacher $user): Collection
    {
        $results = self::results($test, $user);
        $mainRoles = self::mainRoles($test, $user);

        return $results->diff($mainRoles)->sortByDesc('score');
    }

    /**
     * Get the questions for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function questions(): array
    {
        return [
            [
                'text' => __('tests.problemi-problem-gruppo-question-1'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-2'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-3'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-4'),
                'role' => 4,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-5'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-6'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-7'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-8'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-9'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-10'),
                'role' => 4,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-11'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-12'),
                'role' => 4,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-13'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-14'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-15'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-16'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-17'),
                'role' => 4,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-18'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-19'),
                'role' => 2,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-20'),
                'role' => 1,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-21'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-22'),
                'role' => 4,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-23'),
                'role' => 3,
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-24'),
                'role' => 4,
            ],
        ];
    }

    /**
     * Get the roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function roles(): array
    {
        return [
            1 => __('problem-gruppo.role-1-title'),
            2 => __('problem-gruppo.role-2-title'),
            3 => __('problem-gruppo.role-3-title'),
            4 => __('problem-gruppo.role-4-title'),
        ];
    }

    public static function roleDescription(int $roleId): string
    {
        $descriptions = [
            1 => __('problem-gruppo.role-1-description'),
            2 => __('problem-gruppo.role-2-description'),
            3 => __('problem-gruppo.role-3-description'),
            4 => __('problem-gruppo.role-4-description'),
        ];

        return $descriptions[$roleId] ?? '';
    }

    /**
     * Get a specific question by its ID
     */
    public static function getQuestion(int $id): array
    {
        return self::questions()[$id];
    }

    /**
     * Get the answer percentage based on the score value
     */
    public static function getAnswerPercentage(int $value): int
    {
        return round(($value / self::MAX_SCORE) * 100);
    }

    /**
     * Always return 100% for the overall test percentage since it's a role-based test and not a score-based one
     */
    public function calculatePercentage(array $submittedAnswers): int
    {
        return 100;
    }
}
