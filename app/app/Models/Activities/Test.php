<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model {

	/**
	 * The table associated with the model.
	 * 
	 * @var string
	 */
	protected $table = 'activities_tests';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array<string>
	 */
	protected $fillable = [
		'sectionId',
		'areaId',
		'title',
		'description',
		'shortDescription',
		'slug',
		'step',
		'template',
	];

	/**
	 * The short description of the test.
	 * 
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function summary(): Attribute {
		return Attribute::make(
			get: fn(): string => __('tests.summary-' . $this->id)
		);
	}

	/**
	 * Section
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function section(): BelongsTo {
		return $this->belongsTo(Section::class, 'sectionId');
	}

	/**
	 * URL
	 * 
	 * @param int|null $studentId
	 * @return string
	 */
	public function url(?int $studentId): string {
		return '/activities/tests/' . $this->id . ($studentId ? '?student_id=' . $studentId : '');
	}

	/**
	 * File Path
	 * 
	 * @return string
	 */
	public function filePath(): string {
		return $this->section->area->slug . '/' . $this->section->slug . '/' . $this->slug;
	}
}
