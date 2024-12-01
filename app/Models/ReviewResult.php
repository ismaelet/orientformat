<?php

namespace App\Models;

use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewResult extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'studentId',
		'reviewId',
		'results',
	];

	/**
	 * Get the student that owns the review result.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function student(): BelongsTo {
		return $this->belongsTo(Student::class, 'studentId', 'userId');
	}

	/**
	 * Parse the results.
	 * 
	 * @return array
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
