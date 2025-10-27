<?php

namespace App\Models\Activities;

use App\Models\Schools\Grade;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model {

    /**
     * The table associated with the model
     */
    protected $table = 'activities_areas';

    /**
     * Attribute: Description
     */
    public function description(): Attribute {
        return Attribute::make(
            get: fn() => is_student() && student()->isHighSchoolStudent() && $this->id == 4 ? __('areas.choose-highschool-description') : __('areas.' . $this->id . '-description'),
        );
    }

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
