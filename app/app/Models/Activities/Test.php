<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model {

	use SoftDeletes;

	/**
	 * The table associated with the model
	 */
	protected $table = 'tests';

	/**
	 * The attributes that are mass assignable
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
		'reviewable',
	];

	/**
	 * Attribute: The name of the test
	 */
	protected function name(): Attribute {
		return Attribute::make(
			get: fn(): string => $this->title,
		);
	}

	/**
	 * Attribute: The summary of the test
	 */
	protected function summary(): Attribute {
		return Attribute::make(
			get: fn(): string => __('tests.summary-' . $this->id)
		);
	}

	/**
	 * Relationship: The section that owns the test
	 */
	public function section(): BelongsTo {
		return $this->belongsTo(Section::class, 'sectionId');
	}

	/**
	 * Relationship: The tests that are required by this test
	 */
	public function required_tests(): HasMany {
		return $this->hasMany(Test::class, 'recapTestId');
	}

	/**
	 * Relationship: The tests that are required by this test
	 */
	public function previous_tests(): HasMany {
		return $this->hasMany(Test::class, 'followUpTestId');
	}

	/**
	 * Relationship: The tests that are required by this test
	 */
	public function required_test(): BelongsTo {
		return $this->belongsTo(Test::class, 'requiredTestId');
	}

	/**
	 * Relationship: The tests that are required by this test
	 */
	public function dependent_tests(): Collection {
		$requiredTests = $this->required_tests()->get() ?? collect();
		$previousTests = $this->previous_tests()->get() ?? collect();
		$requiredTest = $this->required_test()->first();
		$requiredTestCollection = $requiredTest ? collect([$requiredTest]) : collect();

		return $requiredTests->merge($previousTests)->merge($requiredTestCollection);
	}

	/**
	 * Get the URL for the test
	 */
	public function url(?int $studentId = null): string {
		return route('test', ['test' => $this, 'student_id' => $studentId]);
	}

	/**
	 * Get the view name for the test
	 */
	public function view(): string {
		return $this->section->isCompletable() ? 'tests.' . $this->section->slug . '.' . $this->slug : 'tests.' . $this->section->slug;
	}

	/**
	 * Get the file path for the test
	 * 
	 * ! Legacy
	 */
	public function filePath(): string {
		return $this->section->area->slug . '/' . $this->section->slug . '/' . $this->slug;
	}
}
