<?php

namespace App\Models\Activities;

use App\Models\Schools\Grade;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model {

	use SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'areaId',
		'name',
		'description',
		'evaluation_test_id',
		'result_label',
		'slug',
		'estimated_duration',
		'isStandard',
		'active',
		'mainSectionId'
	];

	/**
	 * The table associated with the model
	 */
	protected $table = 'sections';

	public function description(): Attribute {
		return Attribute::make(
			get: fn() => __(key: 'sections.description-' . $this->slug)
		);
	}

	/**
	 * Relationship: The area that this section belongs to
	 */
	public function area(): BelongsTo {
		return $this->belongsTo(Area::class, 'areaId');
	}

	/**
	 * Relationship: The main section that this section belongs to
	 */
	public function main_section(): BelongsTo {
		return $this->belongsTo(Section::class, 'mainSectionId');
	}

	public function originalSection(): ?self {
		if ($this->main_section) {
			return $this->main_section;
		}

		return $this;
	}

	/**
	 * Relationship: The grades that this section belongs to
	 */
	public function grades(): BelongsToMany {
		return $this->belongsToMany(Grade::class);
	}

	/**
	 * Relationship: The evaluation test for this section
	 */
	public function evaluation_legacy_test(): BelongsTo {
		return $this->belongsTo(Test::class, 'evaluation_test_id');
	}

	/**
	 * Relationship: The tests that belong to this section
	 */
	public function tests(): HasMany {
		return $this->hasMany(Test::class, 'sectionId');
	}

	/**
	 * The tests that can be reviewed for this section
	 */
	public function reviewable_tests(): Collection {
		return $this->tests()
			->where('id', '<>', $this->evaluation_test?->id)
			->where('template', '<>', 'survey')
			->where('followUpTestId', 0)
			->where('recapTestId', 0)
			->get();
	}

	/**
	 * Get the URL for the section
	 */
	public function url(): string {
		if ($this->isCompletable()) {
			return route('section', ['section' => $this]);
		}

		return $this->tests->first()->url();
	}

	/**
	 * Check if the section is completable
	 */
	public function isCompletable(): bool {
		return $this->isStandard;
	}

	/**
	 * Get the count of tests in this section
	 */
	public function testCount(): int {
		return $this->tests->count();
	}

	/**
	 * Get the icon for the section
	 * 
	 * ! Legacy
	 */
	public function legacyIcon(): string {
		$filePath = resource_path('svg/icons/sections/' . $this->slug . '.svg');

		if (file_exists($filePath)) {
			return embed_icon('sections/' . $this->originalSection()->slug);
		} else {
			return embed_icon('sections/section-' . $this->originalSection()->id);
		}
	}
}
