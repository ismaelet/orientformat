<?php

namespace App\Models\Activities;

use App\Models\Schools\Grade;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model {

	/**
	 * The table associated with the model
	 */
	protected $table = 'activities_areas';

	/**
	 * Relationship: The sections that belong to this area
	 */
	public function sections(): HasMany {
		return $this->hasMany(Section::class, 'areaId');
	}

	/**
	 * Relationship: The completable sections that belong to this area
	 */
	public function completable_sections(): HasMany {
		return $this->hasMany(Section::class, 'areaId')->where('isStandard', true);
	}
}
