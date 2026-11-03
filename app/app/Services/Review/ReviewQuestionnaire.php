<?php

namespace App\Services\Review;

use App\Models\Review;
use Legacy\Review\Question;
use Legacy\Review\Review as LegacyReview;

/**
 * Server-side rules of a review questionnaire, derived from the stored questions.
 * Visibility of conditional questions is recomputed from the submitted parent
 * answers; client-side visibility, optional flags and completion state are ignored.
 */
class ReviewQuestionnaire
{
    public const NUMBER_MIN = 1;

    public const NUMBER_MAX = 100;

    /** @var array<string, array{question: Question, fields: array<string, list<string>>}> */
    private array $questions = [];

    public function __construct(Review $review)
    {
        $legacy = new LegacyReview($review->id);

        foreach ($legacy->areas as $area) {
            foreach ($area->getQuestions($review->id) as $question) {
                $this->questions[$question->fullSlug] = [
                    'question' => $question,
                    'fields' => $this->fields($question),
                ];
            }
        }
    }

    /**
     * Validation rules for the given input. Hidden conditional questions get no
     * rules, so their answers are excluded from the validated data.
     *
     * @return array<string, list<string>>
     */
    public function rules(array $input): array
    {
        $visible = $this->visibleDependents($input);
        $rules = [];

        foreach ($this->questions as $slug => ['question' => $question, 'fields' => $fields]) {
            $dependent = array_key_exists($slug, $visible);

            if ($dependent && ! $visible[$slug]) {
                continue;
            }

            $required = $dependent || ! $question->optional;

            if ($question->type === 'number') {
                $rules[$slug] = [
                    $required ? 'required' : 'nullable',
                    'integer',
                    'between:'.self::NUMBER_MIN.','.self::NUMBER_MAX,
                ];

                continue;
            }

            $names = array_keys($fields);
            $atLeastOne = $question->type === 'list' && $question->multiple && count($names) > 1;

            foreach ($fields as $name => $values) {
                $presence = match (true) {
                    ! $required => 'nullable',
                    $atLeastOne => 'required_without_all:'.implode(',', array_diff($names, [$name])),
                    default => 'required',
                };

                $rules[$name] = [$presence, 'string', 'in:'.implode(',', $values)];
            }
        }

        return $rules;
    }

    /** Orders validated answers by questionnaire order and drops empty ones. */
    public function answers(array $validated): array
    {
        $answers = [];

        foreach ($this->questions as $slug => ['question' => $question, 'fields' => $fields]) {
            $names = $question->type === 'number' ? [$slug] : array_keys($fields);

            foreach ($names as $name) {
                $value = $validated[$name] ?? null;

                if ($value !== null && $value !== '' && $value !== '0') {
                    $answers[$name] = (string) $value;
                }
            }
        }

        return $answers;
    }

    /**
     * Whether each conditional question present in the review is visible.
     *
     * @return array<string, bool>
     */
    private function visibleDependents(array $input): array
    {
        $value = function (string $name) use ($input): int {
            $answer = $input[$name] ?? null;

            return is_string($answer) && ctype_digit($answer) ? (int) $answer : 0;
        };

        $rules = [];

        foreach (['3a', '3b', '3c', '3d'] as $index => $suffix) {
            $rules["s2d{$suffix}"] = $value('s2d2_'.($index + 1)) > 1;
        }

        $rules['s6d3'] = $value('s6d2') > 1;
        $rules['s7d3'] = $value('s7d2') === 1;
        $rules['s7d4'] = $value('s7d2') === 2;
        $rules['s7d5'] = $value('s7d2') === 2;

        return array_intersect_key($rules, $this->questions);
    }

    /** @return array<string, list<string>> allowed values per submitted field */
    private function fields(Question $question): array
    {
        $fields = [];

        switch ($question->type) {
            case 'list':
                foreach ($question->rows as $row) {
                    $fields[$row['name']][] = (string) $row['value'];
                }

                break;
            case 'grid':
                foreach ($question->rows as $row) {
                    foreach ($row['content'] as $cell) {
                        $fields[$cell['name']][] = (string) $cell['value'];
                    }
                }

                break;
        }

        return $fields;
    }
}
