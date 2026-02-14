<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [];

    /**
     * Relationship: The review results associated with this review
     */
    public function review_results() {
        return $this->hasMany(ReviewResult::class, 'reviewId', 'id');
    }
}
