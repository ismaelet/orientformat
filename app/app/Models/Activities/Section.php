<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model {

	/**
	 * The table associated with the model
	 */
	protected $table = 'activities_sections';

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
		if (!$this->mainSectionId) {
			return $this->belongsTo(Section::class, 'id');
		}

		return $this->belongsTo(Section::class, 'mainSectionId');
	}

	/**
	 * Get the URL for the section
	 */
	public function url(): string {
		return route('section', ['section' => $this]);
	}
}
