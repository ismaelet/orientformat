<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model {

	/**
	 * The table associated with the model.
	 */
	protected $table = 'activities_sections';

	/**
	 * * Relationships
	 */

	/**
	 * Area
	 */
	public function area(): BelongsTo {
		return $this->belongsTo(Area::class, 'areaId');
	}

	/**
	 * Main section
	 */
	public function main_section(): BelongsTo {
		if (!$this->mainSectionId) {
			return $this->belongsTo(Section::class, 'id');
		}

		return $this->belongsTo(Section::class, 'mainSectionId');
	}

	/**
	 * * Attributes
	 */

	/**
	 * URL
	 */
	public function url(): string {
		return '/activities/sections/' . $this->id;
	}
}
