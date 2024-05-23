<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model {

	/**
	 * The table associated with the model.
	 */
	protected $table = 'activities_tests';

	/**
	 * The attributes that are mass assignable.
	 */
	protected $fillable = [
		'description',
	];

	/**
	 * * Relationships
	 */

	/**
	 * Section
	 */
	public function section(): BelongsTo {
		return $this->belongsTo(Section::class, 'sectionId');
	}

	/**
	 * * Attributes
	 */

	/**
	 * URL
	 */
	public function url(?int $studentId): string {
		return '/activities/tests/' . $this->id . ($studentId ? '?student_id=' . $studentId : '');
	}

	/**
	 * File Path
	 */
	public function filePath(): string {
		return $this->section->area->slug . '/' . $this->section->slug . '/' . $this->slug;
	}
}
