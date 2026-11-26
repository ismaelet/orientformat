<?php

namespace App\Models;

use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewResult extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'studentId',
        'reviewId',
        'results',
    ];

    /**
     * Get the review that owns the review result
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'reviewId', 'id');
    }

    /**
     * Relationship: The student that owns the review result
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'studentId', 'userId');
    }

    /**
     * Decode saved answers using the teacher-facing question labels.
     */
    public function teacherAnswers(): array
    {
        $grouped = [];
        foreach (explode(',', $this->results ?? '') as $pair) {
            if (! str_contains($pair, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $pair, 2);
            [$slug, $field] = array_pad(explode('_', $key, 2), 2, null);
            if ($field !== null) {
                $grouped[$slug][$field] = $value;
            } else {
                $grouped[$slug] = $value;
            }
        }

        $questions = ReviewQuestion::whereIn('full_slug', array_keys($grouped))
            ->where('show_to_teacher', '1')
            ->where(fn ($query) => $query->where('reviewIds', '')
                ->orWhereRaw('FIND_IN_SET(?, reviewIds)', [$this->reviewId]))
            ->get()->keyBy('full_slug');

        $results = [];
        foreach ($grouped as $slug => $values) {
            $question = $questions->get($slug);
            if (! $question) {
                continue;
            }
            $options = $question->rows ? $question->options() : [];
            $columns = $question->gridHeader ? $question->columns() : [];
            $decoded = [];
            foreach (is_array($values) ? $values : [null => $values] as $field => $value) {
                if (is_array($values)) {
                    $label = $options[(int) $field - 1] ?? $field;
                    $answer = $columns[(int) $value - 1] ?? $value;
                } else {
                    $label = '';
                    $answer = $options[(int) $value - 1] ?? $value;
                }
                $decoded[] = ['label' => $label, 'value' => $answer];
            }
            $results[] = ['slug' => $slug, 'question' => $question->teacher_text, 'answers' => $decoded];
        }

        return $results;
    }

    /**
     * Parse the results
     */
    public function results(): array
    {
        $results = [];
        $pairs = explode(',', $this->results);

        foreach ($pairs as $pair) {
            [$key, $value] = explode('=', $pair);

            $results[$key] = $value;
        }

        return $results;
    }
}
