<?php

namespace App\Models;

use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewResult extends Model {

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
    public function review(): BelongsTo {
        return $this->belongsTo(Review::class, 'reviewId', 'id');
    }

    /**
     * Relationship: The student that owns the review result
     */
    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, 'studentId', 'userId');
    }

    /**
     * Parse the results
     */
    public function results(): array {
        $results = [];
        $pairs = explode(',', $this->results);

        foreach ($pairs as $pair) {
            list($key, $value) = explode('=', $pair);

            $results[$key] = $value;
        }

        return $results;
    }
}
