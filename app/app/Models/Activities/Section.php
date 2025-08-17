<?php

namespace App\Models\Activities;

use App\Models\Schools\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
	 * Relationship: The grades that this section belongs to
	 */
	public function grades(): BelongsToMany {
		return $this->belongsToMany(Grade::class);
	}

	/**
	 * Get the URL for the section
	 */
	public function url(): string {
		return route('section', ['section' => $this]);
	}

	/**
	 * Check if the section is completable
	 */
	public function isCompletable(): bool {
		return $this->isStandard;
	}
}
