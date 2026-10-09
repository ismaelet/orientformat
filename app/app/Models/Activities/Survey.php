<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model {

    /**
     * Attribute: Get the answers as an array
     */
    protected function answers(): Attribute {
        return Attribute::make(
            get: fn(string $value): array => array_map(fn($answer) => __(__($answer, [], 'en')), explode(',', $value))
        );
    }

    /**
     * Relationship: The questions that belong to the survey
     */
    public function questions(): HasMany {
        return $this->hasMany(SurveyQuestion::class, 'surveyId')
            ->orderBy('id');
    }

    /**
     * Get the count of answers
     */
    public function answerCount(): int {
        return count($this->answers);
    }

    /**
     * Get the count of questions
     */
    public function questionCount(): int {
        return $this->questions()->count();
    }
}
